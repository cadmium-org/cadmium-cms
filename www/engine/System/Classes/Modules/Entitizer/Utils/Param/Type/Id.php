<?php

namespace System\Modules\Entitizer\Utils\Param\Type {

	use System\Modules\Entitizer;

	class Id extends Entitizer\Utils\Param {

		protected $auto_increment = true;

		# Constructor

		public function __construct(string $name, bool $auto_increment = true) {

			$this->name = $name; $this->auto_increment = $auto_increment;

			$this->index = true; $this->unique = true; $this->primary = true;
		}

		# Get field statement

		public function fieldStatement() {

			return ("`" . $this->name . "` int(10) unsigned NOT NULL") .

			       ($this->auto_increment ? " AUTO_INCREMENT" : "");
		}

		# Cast value

		public function cast($value = null) {

			return ((($value !== null) && is_numeric($value)) ? intval($value) : 0);
		}
	}
}
