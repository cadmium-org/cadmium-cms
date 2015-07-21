<?php

namespace System\Utils\Entity\Param {

    use Number, String, Validate;

	class Range {

        private $name = false, $value = false, $default = false, $index = false;

        # Constructor

        public function __construct($name, $default, $index) {

            $this->name = String::validate($name); $this->default = Number::unsigned($default, 99);

            $this->index = Validate::boolean($index);
        }

        # Set value

        public function set($value) {

            $this->value = Number::unsigned($value);
        }

        # Get field statement

        public function getFieldStatement() {

            return ("`" . $this->name . "` tinyint(2) unsigned NOT NULL DEFAULT '" . $this->default . "'");
        }

        # Get key statement

        public function getKeyStatement() {

            return ($this->index ? ("KEY `" . $this->name . "` (`" . $this->name . "`)") : false);
        }
    }
}

?>
