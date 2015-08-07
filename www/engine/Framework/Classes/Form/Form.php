<?php

namespace {

	class Form {

		private $name = '', $posted = false, $errors = false, $fields = array();

		# Get field configuration

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

			foreach (array_keys($options) as $key => $value) {

				if (isset($config[$key]) && ($config[$key] === '1')) $options[$value] = true;
			}

			return $options;
		}

		# Add field

		private function addField(Form\Utils\Field $field) {

			if ($this->posted) return false;

			if ('' === ($name = $field->name())) return false;

			$this->fields[$name] = $field;

			# ------------------------

			return true;
		}

		# Check POST data

		private function checkPostData() {

			foreach ($this->fields as $name => $field) {

				if ($field->disabled() || ($field instanceof Form\Field\Checkbox)) continue;

				$name = (('' !== $this->name) ? ($this->name . '_' . $name) : $name);

				if (null === ($value = Request::post($name))) return false;
			}

			return true;
		}

		# Constructor

		public function __construct($name = '') {

			$name = strval($name);

			if (('' === $name) || preg_match(REGEX_FORM_NAME, $name)) $this->name = $name;
		}

		# Add input field

		public function input($name, $value = '', $type = FORM_INPUT_TEXT, $maxlength = 0, $placeholder = '', $config = 0) {

			$field = new Form\Field\Input($this, $name, $value);

			$field->type($type); $field->maxlength($maxlength); $field->placeholder($placeholder);

			# Configure field

			$config = $this->getConfig($config);

			$field->error($config[FORM_FIELD_ERROR]);

			$field->disabled($config[FORM_FIELD_DISABLED]);

			$field->required($config[FORM_FIELD_REQUIRED]);

			$field->readonly($config[FORM_FIELD_READONLY]);

			$field->translit($config[FORM_FIELD_TRANSLIT]);

			# ------------------------

			return $this->addField($field);
		}

		# Add select field

		public function select($name, $value, array $options, $default = '', $config = 0) {

			$field = new Form\Field\Select($this, $name, $value);

			$field->options($options, $default);

			# Configure field

			$config = $this->getConfig($config);

			$field->error($config[FORM_FIELD_ERROR]);

			$field->disabled($config[FORM_FIELD_DISABLED]);

			$field->required($config[FORM_FIELD_REQUIRED]);

			$field->search($config[FORM_FIELD_SEARCH]);

			$field->auto($config[FORM_FIELD_AUTO]);

			# ------------------------

			return $this->addField($field);
		}

		# Add checkbox field

		public function checkbox($name, $value = '', $config = 0) {

			$field = new Form\Field\Checkbox($this, $name, $value);

			# Configure field

			$config = $this->getConfig($config);

			$field->error($config[FORM_FIELD_ERROR]);

			$field->disabled($config[FORM_FIELD_DISABLED]);

			$field->required($config[FORM_FIELD_REQUIRED]);

			# ------------------------

			return $this->addField($field);
		}

		# Add hidden field

		public function hidden($name, $value = '') {

			$field = new Form\Field\Hidden($this, $name, $value);

			return $this->addField($field);
		}

		# Catch POST data

		public function post() {

			if ($this->posted || !$this->checkPostData()) return false;

			$errors = false; $post = array();

			foreach ($this->fields as $field) {

				if ($field->post() && $field->error()) $errors = true;

				$post[$field->name()] = $field->value();
			}

			$this->posted = true; $this->errors = $errors;

			# ------------------------

			return $post;
		}

		# Return name

		public function name() {

			return $this->name;
		}

		# Check if posted

		public function posted() {

			return $this->posted;
		}

		# Check for errors

		public function errors() {

			return $this->errors;
		}

		# Get fields

		public function fields() {

			$fields = array();

			foreach ($this->fields as $field) $fields[$field->name()] = $field->block();

			# ------------------------

			return $fields;
		}
	}
}
