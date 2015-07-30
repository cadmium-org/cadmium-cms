<?php

namespace System\Utils\Entity {

	abstract class Param {

        protected $name = false, $value = false, $changed = false;

		# Return name

        public function name() {

            return $this->name;
        }

		# Return value

        public function value() {

            return $this->value;
        }

		# Check if value changed

        public function changed() {

            return $this->changed;
        }
    }
}
