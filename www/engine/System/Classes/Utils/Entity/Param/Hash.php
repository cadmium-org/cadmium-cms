<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity;

	class Hash extends Entity\Utils\Param {

        # Constructor

        public function __construct($name) {

            $this->name = strval($name); $this->value = '';
        }

        # Set value

        public function set($value) {

            return ($this->value = strval($value));
        }

        # Get field statement

        public function getFieldStatement() {

            return ("`" . $this->name . "` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL");
        }

        # Get key statement

        public function getKeyStatement() {

            return ("UNIQUE KEY `" . $this->name . "` (`" . $this->name . "`)");
        }
    }
}
