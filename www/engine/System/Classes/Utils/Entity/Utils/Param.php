<?php

namespace System\Utils\Entity\Utils {

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
    }
}