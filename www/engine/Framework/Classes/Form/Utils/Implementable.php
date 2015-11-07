<?php

namespace Form\Utils {

	use Tag;

	abstract class Implementable extends Field {

		protected $error = false, $disabled = false, $required = false;

		# Get tag

		protected function getTag(string $name, array $attributes = [], $contents = null) {

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

		public function disabled(bool $value = null) {

			if (null === $value) return $this->disabled;

			$this->disabled = $value;
		}

		# Check if field is disabled

		public function required(bool $value = null) {

			if (null === $value) return $this->required;

			$this->required = $value;
		}
	}
}
