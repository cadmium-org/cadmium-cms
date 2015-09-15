<?php

namespace System\Modules\Entitizer\Utils {

    use System\Modules\Entitizer, DB;

	abstract class Entity {

		protected $definition = null;

		protected $init = false, $error = false, $id = 0, $data = array();

        # Init parent entities

		private function getPath() {

			$entity = $this; $path[] = array_merge(['id' => $this->id], $this->data);

			while (0 !== $entity->data['parent_id']) {

				$entity = $entity->definition->get('parent_id')->entity();

				if ((0 === $entity->id)) return array();

                $path[] = array_merge(['id' => $entity->id], $entity->data);
			}

			return array_reverse($path);
		}

        # Get dataset

		private function getDataset(Definition $definition, array $data, $initial = false) {

			$set = array();

            if ($initial && isset($data['id'])) $set['id'] = $definition->id()->set($data['id']);

			foreach ($definition->params() as $name => $param) {

				if (isset($data[$name])) $set[$name] = $param->set($data[$name]);
			}

			return $set;
		}

        # Remove entity

		public function countChildren() {

			DB::select(static::$table, 'COUNT(*) as count', array('parent_id' => $this->id));

			if (!(DB::last() && DB::last()->status)) return false;

			return (intabs(DB::last()->row()['count']));
		}

        # Init entity

        public function init($value, $name = 'id') {

            if ($this->init) return true;

            $value = strval($value); $name = strval($name);

            # Check param name

            if ($name !== 'id') {

                if (false === ($param = $this->definition->get($name))) return false;

				if (!($param instanceof Entitizer\Utils\Param\Type\Hash) &&

					!($param instanceof Entitizer\Utils\Param\Type\Unique)) return false;
            }

            # Select entity from DB

			$selection = array_merge(array('id'), array_keys($this->definition->params()));

			DB::select(static::$table, $selection, array($name => $value), null, 1);

			if (($this->error = !(DB::last() && DB::last()->status)) || (DB::last()->rows !== 1)) return false;

			$data = DB::last()->row();

			# Validate data

			$this->id = $this->definition->id()->set($data['id']);

			foreach ($this->definition->params() as $name => $param) {

                $this->data[$name] = $param->set($data[$name]);
            }

            # Init path

            if (static::$nesting) $this->data['path'] = $this->getPath();

			# Implement entity

			$this->implement();

			# Cache entity

			Entitizer::cache($this);

			# ------------------------

			return ($this->init = true);
		}

        # Constructor

		public function __construct() {

            # Create definition object

			$this->definition = Entitizer::definition(static::$type);
		}

        # Create entity

		public function create(array $data) {

            if ($this->init) return false;

            # Create temporary definition

			$definition = Entitizer::definition(static::$type);

			$set = $this->getDataset($definition, $data, true);

			# Insert entity

			DB::insert(static::$table, $set);

			if (!(DB::last() && DB::last()->status)) return false;

			# Re-init entity

			$this->definition = $definition; $this->id = DB::last()->id;

			foreach ($set as $name => $value) $this->data[$name] = $value;

			if (static::$nesting) $this->data['path'] = static::initPath();

            # Implement entity

			$this->implement();

			# ------------------------

			return ($this->init = true);
		}

		# Edit entity

		public function edit(array $data) {

            if (!$this->init) return false;

            # Create temporary definition

			$definition = Entitizer::definition(static::$type);

			$set = $this->getDataset($definition, $data);

			# Update entity

			DB::update(static::$table, $set, array('id' => $this->id));

			if (!(DB::last() && DB::last()->status)) return false;

			# Re-init entity

			$this->definition = $definition;

			foreach ($set as $name => $value) $this->data[$name] = $value;

            # Implement entity

			$this->implement();

			# ------------------------

			return true;
		}

		# Remove entity

		public function remove() {

			if (!$this->init) return false;

            # Check if entity is removable

            if (static::$super && ($this->id === 1)) return false;

            if (static::$nesting && $this->countChildren() > 0) return false;

            # Remove extension entries

			foreach (static::$extensions as $extension) Entitizer::create($extension, $this->id)->remove();

			# Remove entity

			DB::delete(static::$table, array('id' => $this->id));

			if (!(DB::last() && DB::last()->status)) return false;

			$this->init = false; $this->id = 0; $this->data = array();

			# ------------------------

			return true;
		}

		# Check for init error

		public function error() {

			return $this->error;
		}

        # Return data

		public function __get($name) {

			$name = strval($name);

			if ($name === 'id') return $this->id;

			return (isset($this->data[$name]) ? $this->data[$name] : null);
		}

		# Implementor interface

		abstract protected function implement();
	}
}
