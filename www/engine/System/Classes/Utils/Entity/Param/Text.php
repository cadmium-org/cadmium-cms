<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity;

	class Text extends Entity\Param {

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

            return ("`" . $this->name . "` text NOT NULL");
        }

        # Get key statement

        public function getKeyStatement() {

            return false;
        }
    }
}
