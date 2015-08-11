<?php

namespace System\Utils\Entity\Param\General {

    use System\Utils\Entity;

	class String extends Entity\Utils\Param {

        # Constructor

        public function __construct($name) {

            $this->name = strval($name); $this->value = '';
        }

        # Set value

        public function set($value) {

            return ($this->value = strval($value));
        }
    }
}
