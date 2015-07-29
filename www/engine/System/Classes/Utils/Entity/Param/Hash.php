<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity, String;

	class Hash extends Entity\Param {

        # Constructor

        public function __construct($name) {

            $this->name = String::validate($name);
        }

        # Set value

        public function set($value) {

            return ($this->value = String::validate($value));
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

?>
