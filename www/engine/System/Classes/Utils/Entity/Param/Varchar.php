<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity, Number;

	class Varchar extends Entity\Utils\Param {

        protected $maxlength = 0, $index = false;

        # Constructor

        public function __construct($name, $maxlength = null, $index = false) {

            $this->name = strval($name); $this->value = '';

            $this->maxlength = (($maxlength !== null) ? Number::format($maxlength, 0, 255) : 255);

            $this->index = boolval($index);
        }

        # Set value

        public function set($value) {

            return ($this->value = strval($value));
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
