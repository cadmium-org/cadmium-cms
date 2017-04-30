<?php

namespace Modules\Extend\Utils {

	use Modules\Extend, Utils\Schema, Arr, JSON;

	abstract class Loader {

		protected $dir_name = '', $items = [];

		# Get item

		protected function getItem(string $name) {

			$file_name = ($this->dir_name . $name . '/.Config.json');

			if (null === ($data = JSON::load($file_name))) return null;

			if (null === ($data = Schema::get(static::$schema_prototype)->validate($data))) return null;

			if (!(static::$extension_class::valid($data['name']) && ($data['name'] === $name))) return null;

			# ------------------------

			return $data;
		}

		# Return directory name

		public function dirName() {

			return $this->dir_name;
		}

		# Return items

		public function items(bool $plain = false) {

			return ($plain ? array_column($this->items, 'title', 'name') : $this->items);
		}

		# Check if item exists

		public function exists(string $name) {

			return isset($this->items[$name]);
		}
	}
}
