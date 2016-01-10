<?php

namespace Modules\Entitizer\Utils\Entity\Action {

	use DB;

	trait Edit {

		protected $definition = null, $error = false, $id = 0, $data = [];

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

		# Get dataset interface

		abstract protected function getDataset(array $data, bool $initial = false);

		# Get path interface

		abstract protected function getPath();

		# Implementor interface

		abstract protected function implement();
	}
}
