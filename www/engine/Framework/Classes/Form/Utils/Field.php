<?php

namespace Form\Utils {

	use Form;

	abstract class Field {

		protected $posted = false, $form = null, $name = '', $value = '';

		protected $error = false, $required = false, $readonly = false, $disabled = false;

		protected $search = false, $translit = false, $auto = false;

		# Validate form

		protected function setForm($form) {

			if ($form instanceof Form) $this->form = $form;
		}

		# Validate name

		protected function setName($name) {

			$name = strval($name);

			if (preg_match(REGEX_FORM_FIELD_NAME, $name)) $this->name = $name;
		}

		# Set additional options

		protected function setConfig($config) {

			$config = array_reverse(str_split(decbin(intval($config))));

			$options = array('error', 'required', 'readonly', 'disabled', 'search', 'translit', 'auto');

			foreach ($config as $key => $value) {

				if (($value === '1') && isset($options[$key])) $this->$options[$key] = true;
			}
		}

		# Get name

		protected function getName() {

			if ((null === $this->form) || ('' === ($prefix = $this->form->name()))) return $this->name;

			return (('' !== $this->name) ? ($prefix . '_' . $this->name) : '');
		}

		# Get id

		protected function getId() {

			return str_replace('_', '-', $this->getName());
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

			if (Validate::boolean($value)) $this->error = true;
		}

		# Check if field is disabled

		public function disabled() {

			return $this->disabled;
		}
	}
}
