<?php

namespace {

	class Form {

		private $name = '', $posted = false, $errors = false, $fields = [];

		# Get field configuration

		private function getConfig($config) {

			$config = array_reverse(str_split(decbin(intval($config))));

			$options = [];

			$options[FORM_FIELD_REQUIRED]       = false;
			$options[FORM_FIELD_DISABLED]       = false;
			$options[FORM_FIELD_READONLY]       = false;
			$options[FORM_FIELD_TRANSLIT]       = false;
			$options[FORM_FIELD_AUTOFOCUS]      = false;
			$options[FORM_FIELD_AUTOCOMPLETE]   = false;
			$options[FORM_FIELD_SEARCH]         = false;
			$options[FORM_FIELD_AUTO]           = false;

			foreach (array_keys($options) as $key => $value) {

				if (isset($config[$key]) && ($config[$key] === '1')) $options[$value] = true;
			}

			return $options;
		}

		# Add field to form

		private function addField(Form\Utils\Field $field) {

			if ($this->posted || ('' === ($key = $field->key()))) return false;

			$this->fields[$key] = $field;

			# ------------------------

			return true;
		}

		# Constructor

		public function __construct($name = '') {

			$name = strval($name);

			if (preg_match(REGEX_FORM_NAME, $name)) $this->name = $name;
		}

		# Add input field

		public function input($key, $value = null, $type = FORM_INPUT_TEXT, $maxlength = 0, $placeholder = '', $config = 0) {

			$field = new Form\Field\Input($this, $key, $value, $type, $maxlength, $placeholder);

			# Configure field

			$config = $this->getConfig($config);

			$field->required        ($config[FORM_FIELD_REQUIRED]);

			$field->disabled        ($config[FORM_FIELD_DISABLED]);

			$field->readonly        ($config[FORM_FIELD_READONLY]);

			$field->translit        ($config[FORM_FIELD_TRANSLIT]);

			$field->autofocus       ($config[FORM_FIELD_AUTOFOCUS]);

			$field->autocomplete    ($config[FORM_FIELD_AUTOCOMPLETE]);

			# ------------------------

			return $this->addField($field);
		}

		# Add select field

		public function select($key, $value, array $options, $default = null, $config = 0) {

			$field = new Form\Field\Select($this, $key, $value, $options, $default);

			# Configure field

			$config = $this->getConfig($config);

			$field->required        ($config[FORM_FIELD_REQUIRED]);

			$field->disabled        ($config[FORM_FIELD_DISABLED]);

			$field->search          ($config[FORM_FIELD_SEARCH]);

			$field->auto            ($config[FORM_FIELD_AUTO]);

			# ------------------------

			return $this->addField($field);
		}

		# Add checkbox field

		public function checkbox($key, $value = null, $config = 0) {

			$field = new Form\Field\Checkbox($this, $key, $value);

			# Configure field

			$config = $this->getConfig($config);

			$field->required        ($config[FORM_FIELD_REQUIRED]);

			$field->disabled        ($config[FORM_FIELD_DISABLED]);

			# ------------------------

			return $this->addField($field);
		}

		# Add virtual field

		public function virtual($key) {

			$field = new Form\Utils\Field($this, $key);

			return $this->addField($field);
		}

		# Check POST data

		public function check() {

			$check = false;

			foreach ($this->fields as $field) {

				if (($field instanceof Form\Field\Checkbox)) continue;

				if (($field instanceof Form\Utils\Implementable) && $field->disabled()) continue;

				if (null !== ($value = Request::post($field->name()))) $check = true; else return false;
			}

			return $check;
		}

		# Catch POST data

		public function post() {

			if ($this->posted || !$this->check()) return false;

			$errors = false; $post = [];

			foreach ($this->fields as $field) {

				$field->post(); $post[$field->key()] = $field->value();

				if (($field instanceof Form\Utils\Implementable) && $field->error()) $errors = true;
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

		# Get field object

		public function get($key) {

			$key = strval($key);

			return (isset($this->fields[$key]) ? $this->fields[$key] : null);
		}

		# Implement fields

		public function implement(Template\Utils\Block $block) {

			foreach ($this->fields as $field) {

				if (!($field instanceof Form\Utils\Implementable)) continue;

				$block->block(('field_' . $field->name()), $field->block());
			}
		}
	}
}
