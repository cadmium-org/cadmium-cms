<?php

namespace Modules\Extend\Utils\Loader {

	use Modules\Extend, Utils\Schema, Arr, Explorer;

	abstract class Addons extends Extend\Utils\Loader {

		# Get items

		protected function getItems() {

			$items = [];

			foreach (Explorer::iterateDirs($this->dir_name) as $name) {

				if (null !== ($data = $this->getItem($name))) {

					$items[$name] = $data; $items[$name]['installed'] = false;
				}
			}

			foreach ((Schema::get(static::$schema)->load() ?? []) as $item) {

				if (isset($items[$item['name']])) $items[$item['name']]['installed'] = true;
			}

			# ------------------------

			return Arr::sortby($items, 'title');
		}

		# Get installed items

		protected function getItemsInstalled() {

			$items = [];

			foreach ((Schema::get(static::$schema)->load() ?? []) as $item) {

				if (static::$extension_class::valid($item['name'])) $items[$item['name']] = $item;
			}

			# ------------------------

			return $items;
		}

		# Constructor

		public function __construct(bool $load_all = true) {

			$this->dir_name = static::$root_dir;

			$this->items = ($load_all ? $this->getItems() : $this->getItemsInstalled());
		}

		# Install/uninstall item

		public function install(string $name, bool $value = true) {

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
