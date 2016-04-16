<?php

namespace Modules\Entitizer\Utils\Definition\Item {

	use Modules\Entitizer\Utils\Definition;

	class Foreign extends Definition\Item {

		protected $table = '', $field = '', $delete = null, $update = null;

		# Get action

		private function getAction(string $value) {

			$value = strtoupper($value); $range = ['CASCADE', 'RESTRICT', 'SET NULL'];

			return (in_array($value, $range, true) ? $value : null);
		}

		# Constructor

		public function __construct(string $name, string $table, string $field, string $delete = null, string $update = null) {

			$this->name = $name; $this->table = $table; $this->field = $field;

			if (null !== $delete) $this->delete = $this->getAction($delete);

			if (null !== $update) $this->update = $this->getAction($delete);
		}

		# Get statement

		public function statement() {

			return ("FOREIGN KEY (`" . $this->name . "`) REFERENCES `" . $this->table . "` (`" . $this->field . "`)") .

				   ((null !== $this->delete) ? (" ON DELETE " . $this->delete) : "") .

				   ((null !== $this->update) ? (" ON UPDATE " . $this->update) : "");
		}
	}
}
