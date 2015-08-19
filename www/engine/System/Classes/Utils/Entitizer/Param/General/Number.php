<?php

namespace System\Utils\Entitizer\Param\General {

    use System\Utils\Entitizer;

	abstract class Number extends Entitizer\Utils\Param {

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