<?php

namespace System\Modules\Entitizer\Utils\Param\Type {

	use System\Modules\Entitizer;

	class Id extends Entitizer\Utils\Param\General\Number {

		private $auto_increment = true;

		# Constructor

		public function __construct($name, $auto_increment = true) {

			parent::__construct($name);

			$this->auto_increment = boolval($auto_increment);
		}

		# Get field statement

		public function fieldStatement() {

			$auto_increment = ($this->auto_increment ? " AUTO_INCREMENT" : "");

			return ("`" . $this->name . "` int(10) unsigned NOT NULL" . $auto_increment);
		}

		# Get key statement

		public function keyStatement() {

			return ("PRIMARY KEY (`" . $this->name . "`)");
		}
	}
}
