<?php

/**
 * @package Framework\Form
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	class Form {

		protected $name = '';

		private $posted = false, $errors = false, $fields = [];

		/**
		 * Add a field to the form
		 *
		 * @return true if the field was successfully added, otherwise false
		 */

		private function addField(Form\Field $field) : bool {

			if ($this->posted || ('' === ($key = $field->getKey()))) return false;

			$this->fields[$key] = $field;

			# ------------------------

			return true;
		}

		/**
		 * Constructor
		 */

		public function __construct(string $name = '') {

			if (preg_match(REGEX_FORM_NAME, $name)) $this->name = $name;
		}

		/**
		 * Add a text field
		 *
		 * @return true if the field was successfully added, otherwise false
		 */

		public function addText(string $key, string $value = '',

			string $type = FORM_FIELD_TEXT, int $maxlength = 0, array $config = []) : bool {

			return $this->addField(new Form\Field\Text($this, ...func_get_args()));
		}

		/**
		 * Add a select field
		 *
		 * @return true if the field was successfully added, otherwise false
		 */

		public function addSelect(string $key, string $value = '',

			array $options = [], string $default = null, array $config = []) : bool {

			return $this->addField(new Form\Field\Select($this, ...func_get_args()));
		}

		/**
		 * Add a checkbox field
		 *
		 * @return true if the field was successfully added, otherwise false
		 */

		public function addCheckbox(string $key, string $value = '') : bool {

			return $this->addField(new Form\Field\Checkbox($this, ...func_get_args()));
		}

		/**
		 * Check if valid POST data has been recieved
		 *
		 * @return true if the data has been recieved, otherwise false
		 */

		public function check() : bool {

			$check = false;

			foreach ($this->fields as $field) {

				if (($field instanceof Form\Field\Checkbox) || $field->disabled) continue;

				if (false !== Request::post($field->getName())) $check = true; else return false;
			}

			# ------------------------

			return $check;
		}

		/**
		 * Catch POST data into an array
		 *
		 * @return the result array or false if valid POST data has not been received
		 */

		public function post() {

			if ($this->posted || !$this->check()) return false;

			$post = []; $errors = false;

			foreach ($this->fields as $field) {

				$field->post(); $post[$field->getKey()] = $field->getValue();

				if ($field->error) $errors = true;
			}

			$this->posted = true; $this->errors = $errors;

			# ------------------------

			return $post;
		}

		/**
		 * Get the form name
		 */

		public function getName() : string {

			return $this->name;
		}

		/**
		 * Check if POST data has been catched
		 */

		public function isPosted() : bool {

			return $this->posted;
		}

		/**
		 * Check for errors within the form
		 */

		public function hasErrors() : bool {

			return $this->errors;
		}

		/**
		 * Get a field object
		 *
		 * @return the object or false if the object with the given key does not exist
		 */

		public function getField(string $key) {

			return (isset($this->fields[$key]) ? $this->fields[$key] : false);
		}

		/**
		 * Get the fields array
		 */

		public function getFields() : array {

			return $this->fields;
		}

		/**
		 * Implement the form fields into a given Template\Block object
		 */

		public function implement(Template\Block $block) {

			foreach ($this->fields as $field) {

				$block->setBlock(('field_' . $field->getName()), $field->getBlock());
			}
		}
	}
}
