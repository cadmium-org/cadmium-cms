<?php

/**
 * @package Cadmium\Framework\Form
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Form {

	use Dataset, Form, Request, Tag;

	abstract class Field {

		private $form = null, $posted = false;

		protected $key = '', $name = '', $id = '', $value = null;

		protected $config = [], $dataset = null;

		/**
		 * Initiazlize field with an owner form, a key, and additional configuration
		 */

		protected function init(Form $form, string $key, array $config = []) {

			$this->form = $form;

			# Set key, name, and id

			if (preg_match(REGEX_FORM_FIELD_KEY, $key)) {

				$prefix = (('' !== $this->form->getName()) ? ($this->form->getName() . '_') : '');

				$this->key = $key; $this->name = ($prefix . $key); $this->id = str_replace('_', '-', $this->name);
			}

			# Set configuration

			$general = ['disabled' => false, 'required' => false, 'error' => false];

			$this->dataset = new Dataset($general + $this->config);

			$this->dataset->setArray($config);
		}

		/**
		 * Get a DOM element with a given name, a value, and a set of attributes
		 */

		protected function getTag(string $name, array $attributes = [], $contents = null) : Tag {

			# Set name and id

			$data = ['name' => $this->name, 'id' => $this->id];

			# Set appearance

			if ($this->disabled)    $data['disabled']           = 'disabled';

			if ($this->required)    $data['data-required']      = 'required';

			if ($this->error)       $data['data-error']         = 'error';

			# ------------------------

			return new Tag($name, ($data + $attributes), $contents);
		}

		/**
		 * Catch a POST value by the field key
		 *
		 * @return bool : true on success or false on failure
		 */

		public function post() : bool {

			if ($this->posted || $this->disabled || ('' === $this->key)) return false;

			$this->error = (!$this->setValue(Request::post($this->name)) && $this->required);

			# ------------------------

			return ($this->posted = true);
		}

		/**
		 * Check if a POST value has been catched
		 */

		public function isPosted() : bool {

			return $this->posted;
		}

		/**
		 * Get the field key
		 */

		public function getKey() : string {

			return $this->key;
		}

		/**
		 * Get the field name
		 */

		public function getName() : string {

			return $this->name;
		}

		/**
		 * Get the field id
		 */

		public function getId() : string {

			return $this->id;
		}

		/**
		 * Get the field value
		 */

		public function getValue() {

			return $this->value;
		}

		/**
		 * Set a configuration value
		 */

		public function __set(string $name, $value) {

			$this->dataset->$name = $value;
		}

		/**
		 * Get a configuration value
		 */

		public function __get(string $name) {

			return $this->dataset->$name;
		}

		/**
		 * Check if a configuration value is set
		 */

		public function __isset(string $name) : bool {

			return isset($this->dataset->$name);
		}
	}
}
