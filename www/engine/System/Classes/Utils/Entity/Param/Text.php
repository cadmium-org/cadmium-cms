<?php

namespace System\Utils\Entity\Param {

    use String;

	class Text {

        private $name = false, $value = false;

        # Constructor

        public function __construct($name) {

            $this->name = String::validate($name);
        }

        # Set value

        public function set($value) {

            $this->value = String::validate($value);
        }

        # Get field statement

        public function getFieldStatement() {

            return ("`" . $this->name . "` text NOT NULL");
        }

        # Get key statement

        public function getKeyStatement() {

            return false;
        }
    }
}

?>