<?php

/**
 * @package Framework\Ajax
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Ajax {

	class Response {

		private $data = [], $error = null, $status = true;

		/**
		 * Set a param
		 *
		 * @return the current response object
		 */

		public function set(string $name, $value) : Response {

			if (!in_array($name, ['error', 'status'], true)) $this->data[$name] = $value;

			return $this;
		}

		/**
		 * Set an error and switch the response status to false (default is true)
		 *
		 * @return the current response object
		 */

		public function setError(string $value) : Response {

			$this->error = $value; $this->status = false;

			return $this;
		}

		/**
		 * Get a param
		 *
		 * @return the value or null if the param is not set
		 */

		public function get(string $name) {

			return ($this->data[$name] ?? null);
		}

		/**
		 * Get en error
		 *
		 * @return the value or false if the error is not set
		 */

		public function getError() {

			return ($this->error ?? false);
		}

		/**
		 * Get the response status
		 *
		 * @return true if no error has been set, otherwise false
		 */

		public function getStatus() : bool {

			return $this->status;
		}

		/**
		 * Get the response data
		 *
		 * @return the array containing the response status, the error (if set), and the params set
		 */

		public function getData() : array {

			$data = ['status' => $this->status];

			if (null !== $this->error) $data['error'] = $this->error;

			# ------------------------

			return array_merge($data, $this->data);
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
