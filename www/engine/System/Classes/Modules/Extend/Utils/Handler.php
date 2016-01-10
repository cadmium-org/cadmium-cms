<?php

namespace Modules\Extend\Utils {

	use Modules\Informer, Modules\Settings, Utils\View, Ajax, Arr, Language, Request, Template;

	trait Handler {

		private $section = '', $items = [];

		# Get section

		private function getHandlerSection() {

			return (0 === (strcasecmp(Request::get('list'), SECTION_ADMIN)) ? SECTION_ADMIN : SECTION_SITE);
		}

		# Get items

		private function getHandlerItems() {

			$items = self::items($this->section); $active = key($items);

			$name = Settings::get(self::$param[$this->section]); $primary = self::$default[$this->section];

			if (self::valid($name) && isset($items[$name])) $active = $name;

			else if (self::valid($primary) && isset($items[$primary])) $active = $primary;

			foreach (array_keys($items) as $name) $items[$name]['active'] = ($name === $active);

			# ------------------------

			return Arr::sortby($items, 'title');
		}

		# Get sections loop

		private function getSectionsLoop() {

			$loop = []; $sections = [];

			$sections[SECTION_SITE]     = Language::get('SECTION_SITE');
			$sections[SECTION_ADMIN]    = Language::get('SECTION_ADMIN');

			foreach ($sections as $name => $title) {

				$class = (($name === $this->section) ? 'active item' : 'item');

				$loop[] = ['name' => strtolower($name), 'title' => $title, 'class' => $class];
			}

			return $loop;
		}

		# Get contents

		private function getContents() {

			$contents = View::get(self::$view_main);

			# Set sections

			$contents->sections = $this->getSectionsLoop();

			$contents->section = $this->section;

			# Set items

			$items = Template::group();

			foreach ($this->items as $name => $extension) {

				$items->add($item = View::get(self::$view_item));

				foreach (self::$data as $name) $item->$name = $extension[$name];

				$item->class = ($extension['active'] ? 'positive' : 'grey');
			}

			if ($items->count()) $contents->block('items', $items);

			# ------------------------

			return $contents;
		}

		# Handle ajax request

		private function handleAjax() {

			$ajax = Ajax::response();

			# Check for demo mode

			if (Informer::isDemoMode()) return $ajax->error(Language::get('DEMO_MODE_RESTRICTION'));

			# Save configuration

			$param = self::$param[$this->section]; $name = Request::post('name');

			if (false === Settings::set($param, $name)) return $ajax->error(Language::get(self::$error_name));

			if (false === Settings::save()) return $ajax->error(Language::get(self::$error_save));

			# ------------------------

			return $ajax;
		}

		# Handle common request

		public function handle() {

			$this->section = $this->getHandlerSection();

			$this->items = $this->getHandlerItems();

			if (Request::isAjax()) return $this->handleAjax();

			# ------------------------

			return $this->getContents();
		}
	}
}
