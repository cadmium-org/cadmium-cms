<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity;

	class Id extends Entity\Param {

        # Constructor

        public function __construct($name) {

            $this->name = strval($name); $this->value = 0;
        }

        # Set value

        public function set($value) {

            return ($this->value = intabs($value));
        }

        # Get field statement

        public function getFieldStatement() {

            return ("`" . $this->name . "` int(10) unsigned NOT NULL AUTO_INCREMENT");
        }

        # Get key statement

        public function getKeyStatement() {

            return ("PRIMARY KEY (`" . $this->name . "`)");
        }
    }
}
