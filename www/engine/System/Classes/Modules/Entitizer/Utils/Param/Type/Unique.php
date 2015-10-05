<?php

namespace System\Modules\Entitizer\Utils\Param\Type {

	use System\Modules\Entitizer;

	class Unique extends Varchar {

		# Constructor

		public function __construct($name, $maxlength = null) {

			parent::__construct($name, $maxlength);
		}

		# Get key statement

		public function keyStatement() {

			return ("UNIQUE KEY `" . $this->name . "` (`" . $this->name . "`)");
		}
	}
}
