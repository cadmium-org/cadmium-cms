<?php

/**
 * @package Cadmium\Framework\Ajax
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Ajax {

	class Response {

		private $data = [], $error = null, $status = true;

		/**
		 * Constructor
		 */

		public function __construct(array $data = []) {

			$this->setArray($data);
		}

		/**
		 * Set a param
		 *
		 * @return Ajax\Response : the current response object
		 */

		public function set(string $name, $value) : Response {

			if (!in_array($name, ['error', 'status'], true)) $this->data[$name] = $value;

			return $this;
		}

		/**
		 * Set multiple params
		 *
		 * @return Ajax\Response : the current response object
		 */

		public function setArray(array $data) : Response {

			foreach ($data as $name => $value) $this->set($name, $value);

			return $this;
		}

		/**
		 * Set an error and switch the response status to false (default is true)
		 *
		 * @return Ajax\Response : the current response object
		 */

		public function setError(string $value) : Response {

			$this->error = $value; $this->status = false;

			return $this;
		}

		/**
		 * Get a param
		 *
		 * @return mixed|null : the value or null if the param is not set
		 */

		public function get(string $name) {

			return ($this->data[$name] ?? null);
		}

		/**
		 * Get en error
		 *
		 * @return string|false : the value or false if the error is not set
		 */

		public function getError() {

			return ($this->error ?? false);
		}

		/**
		 * Get the response status
		 *
		 * @return bool : true if the error has not been set, otherwise false
		 */

		public function getStatus() : bool {

			return $this->status;
		}

		/**
		 * Get the response data
		 *
		 * @return array : the array containing the response status, the error (if set), and the set of params
		 */

		public function getData() : array {

			$data = ['status' => $this->status];

			if (null !== $this->error) $data['error'] = $this->error;

			# ------------------------

			return ($data + $this->data);
		}

		/**
		 * An alias for the set method
		 */

		public function __set(string $name, $value) : Response {

			return $this->set($name, $value);
		}

		/**
		 * An alias for the get method
		 */

		public function __get(string $name) {

			return $this->get($name);
		}

		/**
		 * Check if param is set
		 */

		 public function __isset(string $name) : bool {

 			return isset($this->data[$name]);
 		}
	}
}
