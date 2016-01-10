<?php

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer, DB;

	abstract class Entity extends Entitizer {

		use Entity\Action\Init, Entity\Action\Create, Entity\Action\Fill, Entity\Action\Edit, Entity\Action\Remove;

		protected $definition = null, $error = false, $id = 0, $data = [];

		# Init parent entities

		private function getPath() {

			$entity = $this; $path = [array_merge(['id' => $this->id], $this->data)];

			while (0 !== $entity->data['parent_id']) {

				$entity = self::get(static::$type, $entity->data['parent_id']);

				if (0 === $entity->id) return [];

				$path[] = array_merge(['id' => $entity->id], $entity->data);
			}

			# ------------------------

			return array_reverse($path);
		}

		# Get dataset

		private function getDataset(array $data, bool $initial = false) {

			$set = [];

			if ($initial && isset($data['id'])) {

				$set['id'] = $this->definition->id()->cast($data['id']);
			}

			foreach ($this->definition->params() as $name => $param) {

				if (isset($data[$name])) $set[$name] = $param->cast($data[$name]);
			}

			# ------------------------

			return $set;
		}

		# Constructor

		public function __construct(int $id = 0) {

			# Create definition object

			$this->definition = Entitizer\Definition::get(static::$type);

			# Preset data array

			foreach ($this->definition->params() as $name => $param) $this->data[$name] = $param->cast(null);

			# Preset path

			if (static::$nesting) $this->data['path'] = [];

			# Implement entity

			$this->implement();

			# Init entity

			if ($id > 0) $this->init($id);
		}

		# Check if unique param value exists

		public function check(string $name, $value) {

			if ((false === ($param = $this->definition->get($name))) || !$param->unique()) return false;

			# Select entity from DB

			$name = $param->name(); $value = $param->cast($value);

			$condition = ($name . " = '" . addslashes($value) . "' AND id != " . $this->id);

			DB::select(static::$table, 'id', $condition, null, 1);

			# ------------------------

			return ((DB::last() && DB::last()->status) ? DB::last()->rows : false);
		}

		# Count children

		public function children() {

			DB::select(static::$table, 'COUNT(id) as count', ['parent_id' => $this->id]);

			if (!(DB::last() && DB::last()->status)) return false;

			# ------------------------

			return intval(DB::last()->row()['count']);
		}

		# Check for error

		public function error() {

			return $this->error;
		}

		# Return id

		public function id() {

			return $this->id;
		}

		# Return data

		public function data() {

			return $this->data;
		}

		# Getter

		public function __get(string $name) {

			if ($name === 'id') return $this->id;

			return (isset($this->data[$name]) ? $this->data[$name] : null);
		}
	}
}
