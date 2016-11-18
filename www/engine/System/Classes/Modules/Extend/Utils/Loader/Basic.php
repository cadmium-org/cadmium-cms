<?php

namespace Modules\Extend\Utils\Loader {

	use Modules\Extend, Modules\Settings, Arr, Explorer;

	abstract class Basic extends Extend\Utils\Loader {

		protected $section = '', $loaded = false, $primary = null, $active = null;

		# Get section

		protected function getSection(string $section) {

			return (($section === SECTION_ADMIN) ? SECTION_ADMIN : SECTION_SITE);
		}

		# Get directory name

		protected function getDirName() {

			return static::$root_dir[$this->section];
		}

		# Get item

		protected function getItem(string $name) {

			return ($this->loaded ? ($this->items[$name] ?? null) : parent::getItem($name));
		}

		# Get first item

		protected function getFirst() {

			if ($this->loaded) return ($this->items[key($this->items)] ?? null);

			foreach (Explorer::iterateDirs($this->dir_name) as $name) {

				if (null !== ($data = $this->getItem($name))) return $data;
			}

			# ------------------------

			return null;
		}

		# Get items

		protected function getItems() {

			$items = [];

			foreach (Explorer::iterateDirs($this->dir_name) as $name) {

				if (null !== ($data = $this->getItem($name))) $items[$name] = $data;
			}

			# ------------------------

			return Arr::sortby($items, 'title');
		}

		# Get primary item

		protected function getPrimary() {

			$primary = static::$default[$this->section];

			return ($this->getItem($primary) ?? null);
		}

		# Get active item

		protected function getActive() {

			$active = Settings::get(static::$param[$this->section]);

			return ($this->getItem($active) ?? $this->primary ?? $this->getFirst());
		}

		# Constructor

		public function __construct(string $section, bool $load_all = true) {

			$this->section = $this->getSection($section); $this->dir_name = $this->getDirName();

			if ($load_all) { $this->items = $this->getItems(); $this->loaded = true; }

			$this->primary = $this->getPrimary(); $this->active = $this->getActive();
		}

		# Activate item

		public function activate(string $name) {

			if (null === ($data = $this->getItem($name))) return false;

			$this->active = $data;

			# ------------------------

			return true;
		}

		# Return active section

		public function section() {

			return $this->section;
		}

		# Return primary extension name

		public function primary() {

			return ($this->primary['name'] ?? false);
		}

		# Return active extension name

		public function active() {

			return ($this->active['name'] ?? false);
		}

		# Get primary extension path

		public function pathPrimary() {

			if (null === $this->primary) return false;

			return ($this->dir_name . $this->primary['name'] . '/');
		}

		# Get active extension path

		public function path() {

			if (null === $this->active) return false;

			return ($this->dir_name . $this->active['name'] . '/');
		}

		# Get active extension data

		public function data(string $name = null) {

			if (null === $name) return ($this->active ?? false);

			return ($this->active[$name] ?? false);
		}
	}
}
