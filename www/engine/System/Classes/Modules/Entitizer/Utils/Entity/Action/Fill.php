<?php

namespace Modules\Entitizer\Utils\Entity\Action {

	// use DB;

	trait Fill {

		protected $definition = null, $error = false, $id = 0, $data = [];

		# Fill entity with custom data

		public function fill(array $data) {

			if (0 !== $this->id) return false;

			$set = $this->getDataset($data, true);

			if (!isset($set['id']) || !($set['id'] > 0)) return false;

			# Re-init entity

			$this->error = false; $this->id = $set['id'];

			foreach ($set as $name => $value) if ($name !== 'id') $this->data[$name] = $value;

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
