<?php

namespace Utils\Schema {

	use JSON;

	class _Object {

		# File name interface

		protected static $file_name = '';

		# Properties list

		protected $properties = [];

		# Add array property

		protected function addArray(string $name) {

			if ('' !== $name) return $this->properties[$name] = new _Array;
		}

		# Add boolean property

		protected function addBoolean(string $name) {

			if ('' !== $name) return $this->properties[$name] = new _Boolean;
		}

		# Add integer property

		protected function addInteger(string $name) {

			if ('' !== $name) return $this->properties[$name] = new _Integer;
		}

		# Add object property

		protected function addObject(string $name) {

			if ('' !== $name) return $this->properties[$name] = new _Object;
		}

		# Add string property

		protected function addString(string $name) {

			if ('' !== $name) return $this->properties[$name] = new _String;
		}

		# Validate data

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

		# Load JSON file

		public function load() {

			if ('' === static::$file_name) return null;

			$file_name = (DIR_SYSTEM_DATA . static::$file_name);

			if (null === ($data = JSON::load($file_name))) return null;

			if (null === ($data = $this->validate($data))) return null;

			# ------------------------

			return $data;
		}

		# Save JSON file

		public function save(array $data) {

			if ('' === static::$file_name) return false;

			$file_name = (DIR_SYSTEM_DATA . static::$file_name);

			if (null === ($data = $this->validate($data))) return false;

			if (false === JSON::save($file_name, $data)) return false;

			# ------------------------

			return true;
		}
	}
}
