<?php

namespace System\Utils\Entitizer\Param {

	class Time extends General\Number {

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
