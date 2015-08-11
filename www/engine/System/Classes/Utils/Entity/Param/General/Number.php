<?php

namespace System\Utils\Entity\Param\General {

    use System\Utils\Entity;

	class Number extends Entity\Utils\Param {

        # Constructor

        public function __construct($name) {

            $this->name = strval($name); $this->value = 0;
        }

        # Set value

        public function set($value) {

            return ($this->value = intabs($value));
        }
    }
}
