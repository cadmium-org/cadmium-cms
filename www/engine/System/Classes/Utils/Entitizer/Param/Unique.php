<?php

namespace System\Utils\Entitizer\Param {

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
