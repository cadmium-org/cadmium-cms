<?php

namespace {

	class Form {

		private $name = '', $posted = false, $errors = false, $fields = [];

		# Add field to form

		private function addField(Form\Utils\Field $field) {

			if ($this->posted || ('' === ($key = $field->key()))) return false;

			$this->fields[$key] = $field;

			# ------------------------

			return true;
		}

		# Constructor

		public function __construct(string $name = '') {

			if (preg_match(REGEX_FORM_NAME, $name)) $this->name = $name;
		}

		# Add input field

		public function input(string $key, string $value = '', string $type = FORM_INPUT_TEXT, int $maxlength = 0, array $config = []) {

			($field = new Form\Field\Input($this, $key, $type, $maxlength, $config))->set($value);

			return $this->addField($field);
		}

		# Add select field

		public function select(string $key, string $value = '', array $options = [], string $default = null, array $config = []) {

			($field = new Form\Field\Select($this, $key, $options, $default, $config))->set($value);

			return $this->addField($field);
		}

		# Add checkbox field

		public function checkbox(string $key, bool $value = false) {

			($field = new Form\Field\Checkbox($this, $key))->set($value);

			return $this->addField($field);
		}

		# Check POST data

		public function check() {

			$check = false;

			foreach ($this->fields as $field) {

				if (($field instanceof Form\Field\Checkbox) || $field->disabled()) continue;

				if (false !== ($value = Request::post($field->name()))) $check = true; else return false;
			}

			# ------------------------

			return $check;
		}

		# Catch POST data

		public function post() {

			if ($this->posted || !$this->check()) return false;

			$errors = false; $post = [];

			foreach ($this->fields as $field) {

				$field->post(); $post[$field->key()] = $field->value();

				if ($field->error()) $errors = true;
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

		public function get(string $key) {

			return (isset($this->fields[$key]) ? $this->fields[$key] : false);
		}

		# Implement fields

		public function implement(Template\Utils\Block $block) {

			foreach ($this->fields as $field) {

				$block->block(('field_' . $field->name()), $field->block());
			}
		}
	}
}
