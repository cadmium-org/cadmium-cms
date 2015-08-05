<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity, Number;

	class Range extends Entity\Utils\Param {

        private $default = 0, $index = false;

        # Constructor

        public function __construct($name, $default = 0, $index = false) {

            $this->name = strval($name); $this->value = 0;

            $this->default = Number::format($default, 0, 99); $this->index = boolval($index);
        }

        # Set value

        public function set($value) {

            return ($this->value = intabs($value));
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
