<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Utils\Loader {

	use Modules\Extend, Utils\Schema;

	abstract class Addons extends Extend\Utils\Loader {

		/**
		 * Load the list of all items
		 */

		protected function loadItemsAll() : array {

			$items = $this->loadItems(['installed' => false]);

			foreach ((Schema::get(static::$schema)->load() ?? []) as $item) {

				if (isset($items[$item['name']])) $items[$item['name']]['installed'] = true;
			}

			# ------------------------

			return $items;
		}

		/**
		 * Load the list of installed items
		 */

		protected function loadItemsInstalled() : array {

			$items = [];

			foreach ((Schema::get(static::$schema)->load() ?? []) as $item) {

				if (static::$extension_class::isValid($item['name'])) $items[$item['name']] = $item;
			}

			# ------------------------

			return $items;
		}

		/**
		 * Constructor
		 */

		public function __construct(bool $load_all = true) {

			$this->dir_name = static::$root_dir;

			$this->items = ($load_all ? $this->loadItemsAll() : $this->loadItemsInstalled());
		}

		/**
		 * Install or uninstall an item
		 *
		 * @param $value : if set to true the item will be installed, otherwise uninstalled
		 *
		 * @return bool : true on success or false on failure
		 */

		public function install(string $name, bool $value = true) : bool {

			if (!isset($this->items[$name])) return false;

			$items = [];

			foreach ($this->items as $item) {

				if ($value) { if ($item['installed'] || ($item['name'] === $name)) $items[] = $item; }

				else { if ($item['installed'] && ($item['name'] !== $name)) $items[] = $item; }
			}

			if (!Schema::get(static::$schema)->save($items)) return false;

			$this->items[$name]['installed'] = $value;

			# ------------------------

			return true;
		}
	}
}
