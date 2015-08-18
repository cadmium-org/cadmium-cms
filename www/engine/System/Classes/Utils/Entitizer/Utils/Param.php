<?php

namespace System\Utils\Entitizer\Utils {

	abstract class Param {

        protected $name = '', $value = null;

		# Return name

        public function name() {

            return $this->name;
        }

		# Return value

        public function value() {

            return $this->value;
        }

		# Constructor interface

		abstract public function __construct($name);

		# Setter interface

		abstract public function set($value);

		# Field statement getter interface

		abstract public function fieldStatement();

		# Key statement getter interface

		abstract public function keyStatement();
    }
}
