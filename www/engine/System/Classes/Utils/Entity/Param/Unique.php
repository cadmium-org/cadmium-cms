<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity;

	class Unique extends Varchar {

        # Constructor

        public function __construct($name, $maxlength = null) {

            parent::__construct($name, $maxlength);
        }

        # Get key statement

        public function getKeyStatement() {

            return ("UNIQUE KEY `" . $this->name . "` (`" . $this->name . "`)");
        }
    }
}
