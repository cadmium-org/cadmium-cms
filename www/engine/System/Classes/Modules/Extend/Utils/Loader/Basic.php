<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Utils\Loader {

	use Modules\Extend, Modules\Settings, Explorer;

	abstract class Basic extends Extend\Utils\Loader {

		protected $section = '', $loaded = false, $primary = null, $active = null;

		/**
		 * Load an item data
		 *
		 * @return array|null : the data or null on failure
		 */

		protected function loadItem(string $name) {

			return ($this->loaded ? ($this->items[$name] ?? null) : parent::loadItem($name));
		}

		/**
		 * Load a first item data
		 *
		 * @return array|null : the data or null on failure
		 */

		protected function loadFirst() {

			if ($this->loaded) return ($this->items[key($this->items)] ?? null);

			foreach (Explorer::iterateDirs($this->dir_name) as $name) {

				if (null !== ($data = $this->loadItem($name))) return $data;
			}

			# ------------------------

			return null;
		}

		/**
		 * Load a primary item data
		 *
		 * @return array|null : the data or null on failure
		 */

		protected function loadPrimary() {

			$primary = static::$default[$this->section];

			return ($this->loadItem($primary) ?? null);
		}

		/**
		 * Load an active item data
		 *
		 * @return array|null : the data or null on failure
		 */

		protected function loadActive() {

			$active = Settings::get(static::$param[$this->section]);

			return ($this->loadItem($active) ?? $this->primary ?? $this->loadFirst());
		}

		/**
		 * Constructor
		 */

		public function __construct(string $section, bool $load_all = true) {

			$this->section = (($section === SECTION_ADMIN) ? SECTION_ADMIN : SECTION_SITE);

			$this->dir_name = static::$root_dir[$this->section];

			if ($load_all) { $this->items = $this->loadItems(); $this->loaded = true; }

			$this->primary = $this->loadPrimary(); $this->active = $this->loadActive();
		}

		/**
		 * Activate an item
		 *
		 * @param $save : tells to save the new value in the global settings
		 *
		 * @return bool : true on success or false on failure
		 */

		public function activate(string $name, bool $save = false) : bool {

			if (null === ($data = $this->loadItem($name))) return false;

			if ($save && ((!Settings::set(static::$param[$this->section], $name)) || !Settings::save())) return false;

			$this->active = $data;

			# ------------------------

			return true;
		}

		/**
		 * Get the active section
		 */

		public function getSection() : string {

			return $this->section;
		}

		/**
		 * Get the primary item data or a specific param value
		 *
		 * @return array|mixed|false : the data array, the param value, or false if the primary item was not loaded
		 */

		public function getPrimary(string $param = null) {

			if (null !== $param) return ($this->primary[$param] ?? false);

			return ($this->primary ?? false);
		}

		/**
		 * Get the active item data or a specific param value
		 *
		 * @return array|mixed|false : the data array, the param value, or false if the active item was not loaded
		 */

		public function get(string $param = null) {

			if (null !== $param) return ($this->active[$param] ?? false);

			return ($this->active ?? false);
		}
	}
}
