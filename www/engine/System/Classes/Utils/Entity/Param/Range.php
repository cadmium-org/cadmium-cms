<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity, Number;

	class Range extends General\Number {

        private $default = 0, $index = false;

        # Constructor

        public function __construct($name, $default = 0, $index = false) {

            parent::__construct($name);

            $this->default = Number::format($default, 0, 99); $this->index = boolval($index);
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
