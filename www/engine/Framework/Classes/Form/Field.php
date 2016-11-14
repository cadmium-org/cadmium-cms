<?php

/**
 * @package Framework\Form
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Form {

	use Dataset, Form, Request, Tag, Template;

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

			$this->dataset = new Dataset(array_merge($general, $this->config));

			$this->dataset->setArray($config);
		}

		/**
		 * Get a DOM element with a given name, a value, and a set of attributes
		 */

		protected function getTag(string $name, string $value = '', array $attributes = []) {

			$tag = Tag::create($name, $value);

			# Set name and id

			$tag->setAttribute('name', $this->name); $tag->setAttribute('id', $this->id);

			# Set appearance

			if ($this->disabled) $tag->setAttribute('disabled', 'disabled');

			if ($this->required) $tag->setAttribute('data-required', 'required');

			if ($this->error) $tag->setAttribute('data-error', 'error');

			# Set attributes

			foreach ($attributes as $name => $value) {

				if (is_scalar($name) && is_scalar($value)) $tag->setAttribute($name, $value);
			}

			# ------------------------

			return $tag;
		}

		/**
		 * Convert a DOMElement object to a Template\Block object
		 */

		protected function toBlock(\DOMElement $tag) {

			return Template::createBlock($tag->ownerDocument->saveHTML($tag));
		}

		/**
		 * Catch a POST value by the field key
		 *
		 * @return true on success or false on failure
		 */

		public function post() {

			if ($this->posted || $this->disabled || ('' === $this->key)) return false;

			$this->error = (!$this->setValue(Request::post($this->name)) && $this->required);

			# ------------------------

			return ($this->posted = true);
		}

		/**
		 * Check if a POST value has been catched
		 */

		public function isPosted() {

			return $this->posted;
		}

		/**
		 * Get the field key
		 */

		public function getKey() {

			return $this->key;
		}

		/**
		 * Get the field name
		 */

		public function getName() {

			return $this->name;
		}

		/**
		 * Get the field id
		 */

		public function getId() {

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

		public function __isset(string $name) {

			return isset($this->dataset->$name);
		}
	}
}
