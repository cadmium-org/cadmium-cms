<?php

namespace System\Modules\Entitizer\Utils {

	use System\Modules\Entitizer, DB;

	abstract class Entity {

		protected $definition = null;

		protected $error = false, $id = 0, $data = [];

		# Init parent entities

		private function getPath() {

			$entity = $this; $path = [array_merge(['id' => $this->id], $this->data)];

			while (0 !== $entity->data['parent_id']) {

				$entity = Entitizer::create(static::$type, $entity->data['parent_id']);

				if (0 === $entity->id) return [];

				$path[] = array_merge(['id' => $entity->id], $entity->data);
			}

			# ------------------------

			return array_reverse($path);
		}

		# Get dataset

		private function getDataset(array $data, $initial = false) {

			$set = [];

			if ($initial && isset($data['id'])) {

				$set['id'] = $this->definition->id()->validate($data['id']);
			}

			foreach ($this->definition->params() as $name => $param) {

				if (isset($data[$name])) $set[$name] = $param->validate($data[$name]);
			}

			# ------------------------

			return $set;
		}

		# Count children

		private function countChildren() {

			DB::select(static::$table, 'COUNT(id) as count', ['parent_id' => $this->id]);

			if (!(DB::last() && DB::last()->status)) return false;

			# ------------------------

			return intabs(DB::last()->row()['count']);
		}

		# Constructor

		public function __construct() {

			# Create definition object

			$this->definition = Entitizer::definition(static::$type);

			# Preset data array

			foreach ($this->definition->params() as $name => $param) {

				$this->data[$name] = $param->validate(null);
			}

			# Preset path

			if (static::$nesting) $this->data['path'] = [];

			# Implement entity

			$this->implement();
		}

		# Init entity

		public function init($value, $name = 'id') {

			if (0 !== $this->id) return true;

			$name = strval($name);

			# Check param name

			if ($name === 'id') $param = $this->definition->id(); else {

				if (false === ($param = $this->definition->get($name))) return false;

				if (!($param instanceof Entitizer\Utils\Param\Type\Hash) &&

				    !($param instanceof Entitizer\Utils\Param\Type\Unique)) return false;
			}

			# Select entity from DB

			$selection = array_merge(['id'], array_keys($this->definition->params()));

			$name = $param->name(); $value = $param->validate($value);

			DB::select(static::$table, $selection, [$name => $value], null, 1);

			if (($this->error = !(DB::last() && DB::last()->status)) || (DB::last()->rows !== 1)) return false;

			$data = DB::last()->row();

			# Validate data

			$this->id = $this->definition->id()->validate($data['id']);

			foreach ($this->definition->params() as $name => $param) {

				$this->data[$name] = $param->validate($data[$name]);
			}

			# Init path

			if (static::$nesting) $this->data['path'] = $this->getPath();

			# Implement entity

			$this->implement();

			# Cache entity

			Entitizer::cache($this);

			# ------------------------

			return true;
		}

		# Check if unique param value exists

		public function check($name, $value) {

			$name = strval($name);

			if (false === ($param = $this->definition->get($name))) return false;

				if (!($param instanceof Entitizer\Utils\Param\Type\Hash) &&

				    !($param instanceof Entitizer\Utils\Param\Type\Unique)) return false;

			# Select entity from DB

			$name = $param->name(); $value = $param->validate($value);

			$condition = ($name . " = '" . addslashes($value) . "' AND id != " . $this->id);

			DB::select(static::$table, 'id', $condition, null, 1);

			# ------------------------

			return ((DB::last() && DB::last()->status) ? DB::last()->rows : false);
		}

		# Create entity entry in DB

		public function create(array $data) {

			if (0 !== $this->id) return false;

			$set = $this->getDataset($data, true);

			# Insert entity

			DB::insert(static::$table, $set);

			if (!(DB::last() && DB::last()->status)) return false;

			# Re-init entity

			$this->id = DB::last()->id;

			foreach ($set as $name => $value) $this->data[$name] = $value;

			if (static::$nesting) $this->data['path'] = $this->getPath();

			# Implement entity

			$this->implement();

			# ------------------------

			return true;
		}

		# Edit entity entry in DB

		public function edit(array $data) {

			if (0 === $this->id) return false;

			$set = $this->getDataset($data);

			# Update entity

			DB::update(static::$table, $set, ['id' => $this->id]);

			if (!(DB::last() && DB::last()->status)) return false;

			# Re-init entity

			foreach ($set as $name => $value) $this->data[$name] = $value;

			if (static::$nesting) $this->data['path'] = $this->getPath();

			# Implement entity

			$this->implement();

			# ------------------------

			return true;
		}

		# Remove entity entry from DB

		public function remove() {

			if (0 === $this->id) return false;

			# Check if entity is removable

			if (static::$super && ($this->id === 1)) return false;

			if (static::$nesting && ($this->countChildren() !== 0)) return false;

			# Remove extension entries

			foreach (static::$extensions as $extension) {

				$entity = Entitizer::create($extension, $this->id);

				if ($entity->error() || ((0 !== $entity->id) && !$entity->remove())) return false;
			}

			# Remove entity

			DB::delete(static::$table, ['id' => $this->id]);

			if (!(DB::last() && DB::last()->status)) return false;

			$this->id = 0; $this->data = [];

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
