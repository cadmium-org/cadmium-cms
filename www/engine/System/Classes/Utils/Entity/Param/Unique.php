<?php

namespace System\Utils\Entity\Param {

    use Number, String;

	class Unique {

        protected $name = false, $value = false, $maxlength = false;

        # Constructor

        public function __construct($name, $maxlength) {

            $this->name = String::validate($name);

            $this->maxlength = (($maxlength !== null) ? Number::unsigned($maxlength, 255) : 255);
        }

        # Set value

        public function set($value) {

            $this->value = String::validate($value);
        }

        # Get field statement

        public function getFieldStatement() {

            return ("`" . $this->name . "` varchar(" . $this->maxlength . ") NOT NULL");
        }

        # Get key statement

        public function getKeyStatement() {

            return ("UNIQUE KEY `" . $this->name . "` (`" . $this->name . "`)");
        }
    }
}

?>