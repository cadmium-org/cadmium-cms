<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer;

	abstract class Dataset {

		protected $params = null, $virtuals = [], $data = [];

		/**
		 * Add a virtual param
		 */

		protected function addVirtual(string $name, callable $virtual) {

			if (isset($this->params[$name]) || isset($this->virtuals[$name])) return;

			$this->virtuals[$name] = $virtual;
		}

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->params = Entitizer::getDefinition(static::$table)->getParams();

			if (static::$nesting) $this->params['parent_id'] = $this->params['id'];

			$this->init(); $this->reset();
		}

		/**
		 * Reset all the params to their default values
		 *
		 * @return Modules\Entitizer\Utils\Dataset : the current dataset object
		 */

		public function reset() : Dataset {

			# Reset params

			foreach ($this->params as $name => $param) $this->data[$name] = $param->cast(null);

			# Reset virtuals

			foreach ($this->virtuals as $name => $virtual) $this->data[$name] = $virtual($this->data);

			# ------------------------

			return $this;
		}

		/**
		 * Update the params with the values given in the data array
		 *
		 * @return Modules\Entitizer\Utils\Dataset : the current dataset object
		 */

		public function update(array $data) : Dataset {

			# Update params

			foreach ($data as $name => $value) {

				if (isset($this->params[$name])) $this->data[$name] = $this->params[$name]->cast($value);
			}

			# Update extras

			foreach ($this->virtuals as $name => $virtual) $this->data[$name] = $virtual($this->data);

			# ------------------------

			return $this;
		}

		/**
		 * Validate and return the data array without affecting the dataset
		 */

		public function cast(array $data) : array {

			$cast = [];

			foreach ($data as $name => $value) {

				if (isset($this->params[$name])) $cast[$name] = $this->params[$name]->cast($value);
			}

			# ------------------------

			return $cast;
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
		 * An alias for the get method
		 */

		public function __get(string $name) {

			return ($this->data[$name] ?? null);
		}

		/**
		 * Check if a param exists
		 */

		 public function __isset(string $name) : bool {

 			return isset($this->data[$name]);
 		}
	}
}
