<?php

namespace Form\Utils {

	use Form;

	class Fieldset {

		private $form = null;

		# Get configuration

		private function getConfig($config) {

			$config = array_reverse(str_split(decbin(intval($config))));

			$options = array();

			$options[FORM_FIELD_ERROR]          = false;
			$options[FORM_FIELD_DISABLED]       = false;
			$options[FORM_FIELD_REQUIRED]       = false;
			$options[FORM_FIELD_READONLY]       = false;
			$options[FORM_FIELD_TRANSLIT]       = false;
			$options[FORM_FIELD_SEARCH]         = false;
			$options[FORM_FIELD_AUTO]           = false;

			$range = array_keys($options);

			foreach ($config as $key => $value) {

				if (($value === '1') && isset($range[$key])) $options[$range[$key]] = true;
			}

			return $options;
		}

		# Constructor

		public function __construct($form) {

			if ($form instanceof Form) $this->form = $form;
		}

		# Add field to form

		private function add($field) {

			if (null === $this->form) return false;

			return $this->form->add($field);
		}

		# Add input field

		public function input($name, $value = '', $type = FORM_INPUT_TEXT, $maxlength = 0, $placeholder = '', $config = 0) {

			$field = new Form\Field\Input($this->form, $name, $value);

			$field->type($type); $field->maxlength($maxlength); $field->placeholder($placeholder);

			# Configure field

			$config = $this->getConfig($config);

			if ($config[FORM_FIELD_ERROR]) $field->error(true);

			if ($config[FORM_FIELD_DISABLED]) $field->disabled(true);

			if ($config[FORM_FIELD_REQUIRED]) $field->required(true);

			if ($config[FORM_FIELD_READONLY]) $field->readonly(true);

			if ($config[FORM_FIELD_TRANSLIT]) $field->translit(true);

			# ------------------------

			return $this->add($field);
		}

		# Add select field

		public function select($name, $value, array $options, $default = '', $config = 0) {

			$field = new Form\Field\Select($this->form, $name, $value);

			$field->options($options, $default);

			# Configure field

			$config = $this->getConfig($config);

			if ($config[FORM_FIELD_ERROR]) $field->error(true);

			if ($config[FORM_FIELD_DISABLED]) $field->disabled(true);

			if ($config[FORM_FIELD_REQUIRED]) $field->required(true);

			if ($config[FORM_FIELD_SEARCH]) $field->search(true);

			if ($config[FORM_FIELD_AUTO]) $field->auto(true);

			# ------------------------

			return $this->add($field);
		}

		# Add checkbox field

		public function checkbox($name, $value = '', $config = 0) {

			$field = new Form\Field\Checkbox($this->form, $name, $value);

			# Configure field

			$config = $this->getConfig($config);

			if ($config[FORM_FIELD_ERROR]) $field->error(true);

			if ($config[FORM_FIELD_DISABLED]) $field->disabled(true);

			if ($config[FORM_FIELD_REQUIRED]) $field->required(true);

			# ------------------------

			return $this->add($field);
		}

		# Add hidden field

		public function hidden($name, $value = '') {

			$field = new Form\Field\Hidden($this->form, $name, $value);

			return $this->add($field);
		}
	}
}
