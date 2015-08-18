<?php

namespace System\Utils\Entitizer\Param\General {

    use System\Utils\Entitizer;

	abstract class String extends Entitizer\Utils\Param {

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
