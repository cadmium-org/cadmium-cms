<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity, String;

	class Text extends Entity\Param {

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

            return ("`" . $this->name . "` text NOT NULL");
        }

        # Get key statement

        public function getKeyStatement() {

            return false;
        }
    }
}

?>
