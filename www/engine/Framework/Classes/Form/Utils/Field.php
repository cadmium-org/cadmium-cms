<?php

namespace Form\Utils {

	use String;

	abstract class Field {

		protected $posted = false, $form = false, $name = false, $value = false;

		protected $readonly = false, $disabled = false, $search = false, $error = false;

		# Validate name

		protected function validateName($name) {

			$name = String::validate($name);

			return (preg_match(REGEX_FORM_FIELD_NAME, $name) ? $name : false);
		}

		# Set additional options

		protected function setConfig($options) {

			if (false === $options) return;

			if (!is_array($options)) $options = array($options);

			foreach ($options as $value) {

				if ($value === FORM_FIELD_READONLY) $this->readonly = true;

				if ($value === FORM_FIELD_DISABLED) $this->disabled = true;

				if ($value === FORM_FIELD_SEARCH) $this->search = true;

				if ($value === FORM_FIELD_ERROR) $this->error = true;
			}
		}

		# Get name

		protected function getName() {

			if ((false === $this->form) || (false === ($prefix = $this->form->name()))) return $this->name;

			return ((false !== $this->name) ? ($prefix . '_' . $this->name) : false);
		}

		# Get id

		protected function getId() {

			return str_replace('_', '-', $this->getName());
		}

		# Convert object to string

		public function __toString() {

			return strval($this->value);
		}

		# Return name

		public function name() {

			return $this->name;
		}

		# Return value

		public function value($value = null) {

			if (null === $value) return $this->value;

			$this->value = String::validate($value);
		}

		# Set error

		public function error() {

			$this->error = true;
		}

		# Check if field disabled

		public function disabled() {

			return $this->disabled;
		}
	}
}

?>
