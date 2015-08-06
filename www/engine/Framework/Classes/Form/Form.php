<?php

namespace {

	class Form {

		private $name = '', $fieldset = null, $posted = false, $errors = false, $fields = array();

		# Constructor

		public function __construct($name = '') {

			$name = strval($name);

			if (('' === $name) || preg_match(REGEX_FORM_NAME, $name)) $this->name = $name;

			$this->fieldset = new Form\Utils\Fieldset($this);
		}

		# Add field

		public function add($field) {

			if ($this->posted) return false;

			if (!($field instanceof Form\Utils\Field)) return false;

			if ('' === ($name = $field->name())) return false;

			$this->fields[$name] = $field;

			# ------------------------

			return true;
		}

		# Catch POST data

		public function post() {

			if ($this->posted) return false;

			# Check POST array

			foreach ($this->fields as $name => $field) {

				if ($field->disabled() || ($field instanceof Form\Field\Checkbox)) continue;

				$name = (('' !== $this->name) ? ($this->name . '_' . $name) : $name);

				if (null === ($value = Request::post($name))) return false;
			}

			# Post fields values

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

		# Return fieldset

		public function fieldset() {

			return $this->fieldset;
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
