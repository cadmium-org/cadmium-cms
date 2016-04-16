<?php

namespace Modules\Entitizer\Utils\Definition\Item {

	use Modules\Entitizer\Utils\Definition;

	class Index extends Definition\Item {

		protected $type = null;

		# Get type

		private function getType(string $value) {

			$value = strtoupper($value); $range = ['PRIMARY', 'UNIQUE', 'FULLTEXT'];

			return (in_array($value, $range, true) ? $value : null);
		}

		# Constructor

		public function __construct(string $name, string $type = null) {

			$this->name = $name;

			if (null !== $type) $this->type = $this->getType($type);
		}

		# Get statement

		public function statement() {

			return ((null !== $this->type) ? ($this->type . " ") : "") .

			       ("KEY `" . $this->name . "` (`" . $this->name . "`)");
		}
	}
}
