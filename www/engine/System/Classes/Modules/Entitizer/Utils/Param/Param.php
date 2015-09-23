<?php

namespace System\Modules\Entitizer\Utils {

	abstract class Param {

        protected $name = '';

		# Return name

        public function name() {

            return $this->name;
        }

		# Constructor interface

		abstract public function __construct($name);

		# Validator interface

		abstract public function validate($value);

		# Field statement getter interface

		abstract public function fieldStatement();

		# Key statement getter interface

		abstract public function keyStatement();
    }
}
