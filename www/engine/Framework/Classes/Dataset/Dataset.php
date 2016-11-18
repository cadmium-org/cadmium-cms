<?php

/**
 * @package Framework\Dataset
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	class Dataset {

		private $data = [], $defaults = [], $validators = [];

		/**
		 * Constructor
		 */

		public function __construct(array $data = []) {

			$this->addParams($data);
		}

		/**
		 * Create a param with a given name, a default value, and a validator function.
		 * Every time you update the param, a given value is being passed to the validator as an argument.
		 * The returned value is being appended to the dataset. If the validator returns null, the dataset is not being affected.
		 * If a validator was not given, a default validator will be used to convert a given variable type to a default's type.
		 * In a case the conversion fails an existing value will not be changed
		 *
		 * @return Dataset : the current dataset object
		 */

		public function addParam(string $name, $default, callable $validator = null) : Dataset {

			if ('' === $name) return $this;

			$this->data[$name] = $default; $this->defaults[$name] = $default;

			$this->validators[$name] = ($validator ?? Dataset\Validator::get($default));

			# ------------------------

			return $this;
		}

		/**
		 * Add multiple params
		 *
		 * @return Dataset : the current dataset object
		 */

		public function addParams(array $data) : Dataset {

			foreach ($data as $name => $value) if (is_scalar($name)) $this->addParam($name, $value);

			return $this;
		}

		/**
		 * Update a value
		 *
		 * @return bool|null : true on success, false on error, or null if the param does not exist
		 */

		public function set(string $name, $value) {

			if (!isset($this->validators[$name])) return null;

			try {

				if (null === ($value = $this->validators[$name]($value))) return false;

				else { $this->data[$name] = $value; return true; }
			}

			catch (TypeError $e) { return false; }
		}

		/**
		 * Update multiple values
		 *
		 * @return array : the array of update results for every param (true on success or false on error)
		 */

		public function setArray(array $data) : array {

			$setted = [];

			foreach ($data as $name => $value) {

				if (null !== ($value = $this->set($name, $value))) $setted[$name] = $value;
			}

			# ------------------------

			return $setted;
		}

		/**
		 * Validate and return a value without affecting the dataset
		 *
		 * @return mixed|null : the validated value or null if the param does not exist
		 */

		public function cast(string $name, $value) {

			if (!isset($this->validators[$name])) return null;

			try {

				if (null !== ($value = $this->validators[$name]($value))) return $value;

				else return $this->data[$name];
			}

			catch (TypeError $e) { return $this->data[$name]; }
		}

		/**
		 * Validate and return multiple values without affecting the dataset
		 *
		 * @return array : the array of validated values or the array of all values if $return_all is true
		 */

		public function castArray(array $data, bool $return_all = false) : array {

			$casted = [];

			foreach ($data as $name => $value) {

				if (null !== ($value = $this->cast($name, $value))) $casted[$name] = $value;
			}

			# ------------------------

			return ($return_all ? array_replace($this->data, $casted) : $casted);
		}

		/**
		 * Reset all the values to their defaults
		 */

		public function reset() {

			$this->data = $this->defaults;
		}

		/**
		 * Get a param value
		 *
		 * @return mixed|null : the value or null if the param does not exist
		 */

		public function get(string $name) {

			return ($this->data[$name] ?? null);
		}

		/**
		 * Get the array of params and their values
		 */

		public function getData() : array {

			return $this->data;
		}

		/**
		 * Get the array of params and their default values
		 */

		public function getDefaults() : array {

			return $this->defaults;
		}

		/**
		 * An alias for the set method
		 */

		public function __set(string $name, $value) {

			return $this->set($name, $value);
		}

		/**
		 * An alias for the get method
		 */

		public function __get(string $name) {

			return $this->get($name);
		}

		/**
		 * Check if a param exists
		 */

		 public function __isset(string $name) : bool {

 			return isset($this->data[$name]);
 		}
	}
}
