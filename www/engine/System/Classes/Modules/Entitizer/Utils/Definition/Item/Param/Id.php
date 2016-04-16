<?php

namespace Modules\Entitizer\Utils\Definition\Item\Param {

	use Modules\Entitizer\Utils\Definition;

	class Id extends Definition\Item\Param {

		protected $auto_increment = true;

		# Constructor

		public function __construct(bool $auto_increment = true) {

			$this->name = 'id'; $this->auto_increment = $auto_increment;
		}

		# Get statement

		public function statement() {

			return ("`" . $this->name . "` int(10) UNSIGNED NOT NULL" . ($this->auto_increment ? " AUTO_INCREMENT" : ""));
		}

		# Cast value

		public function cast($value = null) {

			return (((null !== $value) && is_scalar($value) && (($value = intval($value)) >= 0)) ? $value : 0);
		}
	}
}
