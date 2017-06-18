<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Utils {

	use Utils\Schema, Arr, JSON, Explorer;

	abstract class Loader {

		protected $dir_name = '', $items = [];

		/**
		 * Load items
		 */

		protected function loadItems(array $pattern = []) : array {

			$items = [];

			foreach (Explorer::iterateDirs($this->dir_name) as $name) {

				if (null !== ($data = $this->loadItem($name))) $items[$name] = ($pattern + $data);
			}

			# ------------------------

			return Arr::sortby($items, 'title');
		}

		/**
		 * Load an item data
		 *
		 * @return array|null : the data or null on failure
		 */

		protected function loadItem(string $name) {

			$path = ($this->dir_name . $name . '/');

			if (null === ($data = JSON::load($path . '.Config.json'))) return null;

			if (null === ($data = Schema::get(static::$schema_prototype)->validate($data))) return null;

			if (!(static::$extension_class::isValid($data['name']) && ($data['name'] === $name))) return null;

			# ------------------------

			return (['path' => $path] + $data);
		}

		/**
		 * Get the directory name
		 */

		public function getDirName() : string {

			return $this->dir_name;
		}

		/**
		 * Get an item
		 *
		 * @return array|false : the item or false if the item does not exist
		 */

		public function getItem(string $name) {

			return ($this->items[$name] ?? false);
		}

		/**
		 * Get the items list
		 *
		 * @param $plain : tells to return the array in simplified format ([$name => $title])
		 */

		public function getItems(bool $plain = false) : array {

			return ($plain ? array_column($this->items, 'title', 'name') : $this->items);
		}
	}
}
