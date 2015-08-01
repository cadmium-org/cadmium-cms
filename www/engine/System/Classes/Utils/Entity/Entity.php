<?php

namespace System\Utils\Entity {

	use DB, Number, String, Validate;

	abstract class Entity {

		private $type = false, $table = false, $nesting = false, $has_super = false, $foreign = array();

		protected $params = false, $id = false, $data = false, $created_id = false, $path = false;

		# Get path

		private function getPath() {

			if (!$this->nesting) return false;

			$entity = $this; $path = array($entity);

			while (0 !== $entity->data['parent_id']) {

				$entity = $entity->params->get('parent_id')->entity();

				if (false !== $entity) $path[] = $entity; else return false;
			}

			return array_reverse($path);
		}

		# Add foreign relation

		protected function addForeign($type, $field) {

			if (false === ($type = String::validate($type))) return false;

			if (false === ($field = String::validate($field))) return false;

			$class_name = ('System\\Utils\\Entity\\Type\\' . $type . '\\Definition');

			$table = @constant($class_name . '::TABLE');

			$this->foreign[$table] = $field;

			# ------------------------

			return true;
		}

        # Constructor

        public function __construct() {

			$class_name = get_class($this);

			$this->type = String::validate(@constant($class_name . '::TYPE'));

			$this->table = String::validate(@constant($class_name . '::TABLE'));

			$this->nesting = Validate::boolean(@constant($class_name . '::NESTING'));

			$this->has_super = Validate::boolean(@constant($class_name . '::HAS_SUPER'));

			$this->params = new Params();

			if ($this->nesting) $this->params->relation('parent_id', $this->type);

            # Define entity presets

            $this->define();
        }

		# Create table

		public function createTable() {

            $set = array_merge($this->params->fieldset(), $this->params->keyset());

            $query = ("CREATE TABLE IF NOT EXISTS `" . $this->table . "`") .

                     ("(" . implode(", ", $set) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8");

            # ------------------------

            return (DB::send($query) && DB::last()->status);
		}

		# Init entity by id

		public function init($id) {

			if (false !== $this->id) return true;

			if (0 === ($id = Number::unsigned($id))) return false;

			# Select entity from DB

			$selection = array_merge(array('id'), array_keys($this->params->get()));

			DB::select($this->table, $selection, array('id' => $id), false, 1);

			if (!(DB::last() && (DB::last()->rows === 1))) return false;

			$data = DB::last()->row();

			# Validate data

			$this->id = $this->params->id()->set($data['id']);

			foreach ($this->params->get() as $name => $param) $this->data[$name] = $param->set($data[$name]);

			if ($this->nesting) $this->path = $this->getPath();

			# Implement entity

			$this->implement();

			# Cache entity

			Factory::cache($this->type, $this);

			# ------------------------

			return true;
		}

		# Init entity by unique param

		public function initBy($name, $value) {

			if (false !== $this->id) return true;

			if (false === ($param = $this->params->get($name))) return false;

			if (!($param instanceof Param\Unique)) return false;

			# Select entity from DB

			$selection = array_merge(array('id'), array_keys($this->params->get()));

			DB::select($this->table, $selection, array($name => $value), false, 1);

			if (!(DB::last() && (DB::last()->rows === 1))) return false;

			$data = DB::last()->row();

			# Validate data

			$this->id = $this->params->id()->set($data['id']);

			foreach ($this->params->get() as $name => $param) $this->data[$name] = $param->set($data[$name]);

			# Implement entity

			$this->implement();

			# Cache entity

			Factory::cache($this->type, $this);

			# ------------------------

			return true;
		}

		# Create entity

		public function create($data) {

			if ((false !== $this->id) && !$this->nesting) return false;

			$set = array(); $params = clone $this->params;

			# Set values

			if ($this->nesting) $params->get('parent_id')->set($this->id);

			foreach ($params->get() as $name => $param) {

				if (isset($data[$name])) $param->set($data[$name]);

				if (($param instanceof Param\Relation) && (false === $param->entity())) {

					if ($param->name() !== 'parent_id') return false;

					$set['parent_id'] = $param->set(false);

				} else $set[$name] = $param->value();
			}

			# Insert entity

			DB::insert($this->table, $set);

			if (!(DB::last() && DB::last()->status)) return false;

			$this->created_id = DB::last()->id;

			if ($this->nesting) return true;

			# Re-init entity

			$this->params = $params; $this->id = $this->created_id;

			foreach ($set as $name => $value) $this->data[$name] = $value;

			# Implement entity

			$this->implement();

			# ------------------------

			return true;
		}

		# Edit entity

		public function edit($data) {

			if (false === $this->id) return false;

			$set = array(); $params = clone $this->params;

			# Set values

			foreach ($params->get() as $name => $param) {

				if (isset($data[$name])) $param->set($data[$name]);

				if (($param instanceof Param\Relation) && (false === $param->entity())) {

					if ($param->name() !== 'parent_id') return false;

					$set['parent_id'] = $param->set(false);

				} else $set[$name] = $param->value();
			}

			# Update entity

			DB::update($this->table, $set, array('id' => $this->id));

			if (!(DB::last() && DB::last()->status)) return false;

			# Re-init entity

			$this->params = $params;

			foreach ($set as $name => $value) $this->data[$name] = $value;

			# Implement entity

			$this->implement();

			# ------------------------

			return true;
		}

		# Remove entity

		public function remove() {

			if (false === $this->id) return false;

			if ($this->has_super && ($this->id === 1)) return false;

			# Count children

			if ($this->nesting) {

				DB::select($this->table, 'COUNT(*) as count', array('parent_id' => $this->id));

				if (!(DB::last() && DB::last()->status)) return false;

				if (Number::unsigned(DB::last()->row()['count']) > 0) return false;
			}

			# Delete foreign related entries

			foreach ($this->foreign as $table => $field) {

				DB::delete($table, array($field => $this->id));

				if (!(DB::last() && DB::last()->status)) return false;
			}

			# Remove entity

			DB::delete($this->table, array('id' => $this->id));

			if (!(DB::last() && DB::last()->status)) return false;

			$this->id = false; $this->data = false; $this->created_id = false; $this->path = false;

			# ------------------------

			return true;
		}

		# Return entity data

		public function __get($name) {

			$name = String::validate($name);

			if ($name === 'id') return $this->id;

			if ($name === 'created_id') return $this->created_id;

			return (isset($this->data[$name]) ? $this->data[$name] : false);
		}
	}
}
