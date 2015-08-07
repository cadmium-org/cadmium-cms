<?php

namespace Form\Utils {

	use Form;

	abstract class Field {

		protected $posted = false, $form = null, $name = '', $value = '';

		protected $error = false, $disabled = false, $required = false;

		# Get name

		protected function getName() {

			if ((null === $this->form) || ('' === ($prefix = $this->form->name()))) return $this->name;

			return (('' !== $this->name) ? ($prefix . '_' . $this->name) : '');
		}

		# Get attributes

		protected function getAttributes() {

			$attributes = array();

			# Set name/id

			$attributes['name'] = ($name = $this->getName());

			$attributes['id'] = str_replace('_', '-', $name);

			# Set config

			if ($this->error) $attributes['data-error'] = 'error';

			if ($this->disabled) $attributes['disabled'] = 'disabled';

			# ------------------------

            return $attributes;
		}

		# Validate form

		public function __construct($form, $name, $value) {

			if ($form instanceof Form) $this->form = $form;

			$name = strval($name); $value = strval($value);

			if (preg_match(REGEX_FORM_FIELD_NAME, $name)) $this->name = $name;

			$this->value = $value;
		}

		# Return name

		public function name() {

			return $this->name;
		}

		# Return value

		public function value() {

			return $this->value;
		}

		# Return/set error

		public function error($value = null) {

			if (null === $value) return $this->error;

			if (boolval($value)) $this->error = true;
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
	}
}
