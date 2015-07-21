<?php

namespace System\Utils\Entity\Param {

    use Number, String, Validate;

	class Varchar {

        protected $name = false, $value = false, $maxlength = false, $index = false;

        # Constructor

        public function __construct($name, $maxlength, $index) {

            $this->name = String::validate($name);

            $this->maxlength = (($maxlength !== null) ? Number::unsigned($maxlength, 255) : 255);

            $this->index = Validate::boolean($index);
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

            return ($this->index ? ("KEY `" . $this->name . "` (`" . $this->name . "`)") : false);
        }
    }
}

?>
