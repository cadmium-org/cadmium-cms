<?php

namespace Modules\Entitizer\Utils\Entity\Action {

	use DB;

	trait Create {

		protected $definition = null, $error = false, $id = 0, $data = [];

		# Create entity entry in DB

		public function create(array $data) {

			if (0 !== $this->id) return false;

			$set = $this->getDataset($data, true);

			if (isset($set['id']) && !($set['id'] > 0)) return false;

			# Insert entity

			DB::insert(static::$table, $set);

			if (!(DB::last() && DB::last()->status)) return false;

			# Re-init entity

			$this->error = false; $this->id = DB::last()->id;

			foreach ($set as $name => $value) if ($name !== 'id') $this->data[$name] = $value;

			if (static::$nesting) $this->data['path'] = $this->getPath();

			# Implement entity

			$this->implement();

			# Cache entity

			self::$cache[static::$type][$this->id] = $this;

			# ------------------------

			return true;
		}

		# Get dataset interface

		abstract protected function getDataset(array $data, bool $initial = false);

		# Get path interface

		abstract protected function getPath();

		# Implementor interface

		abstract protected function implement();
	}
}
