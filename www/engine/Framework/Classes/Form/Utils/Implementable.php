<?php

namespace Form\Utils {

    use Tag;

	abstract class Implementable extends Field {

		protected $error = false, $disabled = false, $required = false;

		# Get tag

		protected function getTag($name, array $attributes = array(), $contents = null) {

            $tag = new Tag($name, $attributes, $contents);

            $tag->set('name', $this->name);

            $tag->set('id', str_replace('_', '-', $this->name));

			# Set config

			if ($this->error) $tag->set('data-error', 'error');

            if ($this->required) $tag->set('data-required', 'required');

			if ($this->disabled) $tag->set('disabled', 'disabled');

			# ------------------------

            return $tag;
		}

		# Get value

		public function post() {

			if ($this->disabled() || !parent::post()) return false;

            if (!$this->set($this->value)) $this->error = true;

            # ------------------------

            return true;
		}

		# Check if error

		public function error() {

			return $this->error;
		}

		# Check if field is disabled

		public function disabled($value = null) {

			if (null === $value) return $this->disabled;

			if (boolval($value)) $this->disabled = true;
		}

		# Check if field is disabled

		public function required($value = null) {

			if (null === $value) return $this->required;

			if (boolval($value)) $this->required = true;
		}

        # Setter interface

        abstract public function set($value);

        # Block getter interface

        abstract public function block();
	}
}
