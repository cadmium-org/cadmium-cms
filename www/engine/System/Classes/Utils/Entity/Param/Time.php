<?php

namespace System\Utils\Entity\Param {

    use Number, String;

	class Time {

        private $name = false, $value = false;

        # Constructor

        public function __construct($name) {

            $this->name = String::validate($name);
        }

        # Set value

        public function set($value) {

            $this->value = Number::unsigned($value);
        }

        # Get field statement

        public function getFieldStatement() {

            return ("`" . $this->name . "` int(10) unsigned NOT NULL DEFAULT '0'");
        }

        # Get key statement

        public function getKeyStatement() {

            return ("KEY `" . $this->name . "` (`" . $this->name . "`)");
        }
    }
}

?>
