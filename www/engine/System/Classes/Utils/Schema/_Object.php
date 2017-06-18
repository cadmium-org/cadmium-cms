<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Schema {

	use Explorer, JSON;

	class _Object {

		# File name interface

		protected static $file_name = '';

		# Properties list

		protected $properties = [];

		/**
		 * Add an array property
		 */

		protected function addArray(string $name) {

			if ('' !== $name) return $this->properties[$name] = new _Array;
		}

		/**
		 * Add a boolean property
		 */

		protected function addBoolean(string $name) {

			if ('' !== $name) return $this->properties[$name] = new _Boolean;
		}

		/**
		 * Add an integer property
		 */

		protected function addInteger(string $name) {

			if ('' !== $name) return $this->properties[$name] = new _Integer;
		}

		/**
		 * Add an object property
		 */

		protected function addObject(string $name) {

			if ('' !== $name) return $this->properties[$name] = new _Object;
		}

		/**
		 * Add a string property
		 */

		protected function addString(string $name) {

			if ('' !== $name) return $this->properties[$name] = new _String;
		}

		/**
		 * Validate data
		 *
		 * @return array|null : the validated data or null on failure
		 */

		public function validate($data) {

			if (!is_array($data)) return null;

			$result = [];

			foreach ($this->properties as $name => $property) {

				if (!isset($data[$name]) || (null === ($value = $property->validate($data[$name])))) return null;

				$result[$name] = $value;
			}

			# ------------------------

			return $result;
		}

		/**
		 * Load the JSON file
		 *
		 * @return array|null : the validated data or null on failure
		 */

		public function load() {

			if ('' === static::$file_name) return null;

			$file_name = (DIR_SYSTEM_DATA . static::$file_name);

			if (null === ($data = JSON::load($file_name))) return null;

			if (null === ($data = $this->validate($data))) return null;

			# ------------------------

			return $data;
		}

		/**
		 * Save the JSON file
		 *
		 * @return bool : true on success or false on failure
		 */

		public function save(array $data) : bool {

			if ('' === static::$file_name) return false;

			$file_name = (DIR_SYSTEM_DATA . static::$file_name);

			if (null === ($data = $this->validate($data))) return false;

			if (false === JSON::save($file_name, $data)) return false;

			# ------------------------

			return true;
		}

		/**
		 * Remove the JSON file
		 *
		 * @return bool : true on success or false on failure
		 */

		public function remove() : bool {

			if ('' === static::$file_name) return false;

			$file_name = (DIR_SYSTEM_DATA . static::$file_name);

			return (!Explorer::isFile($file_name) || Explorer::removeFile($file_name));
		}
	}
}
