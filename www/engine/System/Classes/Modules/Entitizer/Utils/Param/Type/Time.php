<?php

namespace System\Modules\Entitizer\Utils\Param\Type {

	use System\Modules\Entitizer;

	class Time extends Entitizer\Utils\Param\General\Number {

		# Get field statement

		public function fieldStatement() {

			return ("`" . $this->name . "` int(10) unsigned NOT NULL DEFAULT '0'");
		}

		# Get key statement

		public function keyStatement() {

			return ("KEY `" . $this->name . "` (`" . $this->name . "`)");
		}
	}
}
