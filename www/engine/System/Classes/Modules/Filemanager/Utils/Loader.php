<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Utils {

	use Explorer, Str;

	class Loader {

		private $parent = null, $index = 0, $display = 0, $items = [], $total = 0;

		/**
		 * Constructor
		 */

		public function __construct(Container $parent) {

			$this->parent = $parent;
		}

		/**
		 * Load items from the filesystem
		 *
		 * @param $index        a page index
		 * @param $display      a number of results per page
		 *
		 * @return Modules\Filemanager\Utils\Loader : the current loader object
		 */

		public function load(int $index = 0, int $display = 0) : Loader {

			if (!(($index >= 0) && ($display >= 0))) return $this;

			$dirs = []; $files = [];

			# Read parent directory contents

			foreach (Explorer::iterate($this->parent->getPathFull()) as $name) {

				if (!($entity = new Entity($this->parent, $name))->isInited()) continue;

				if ($entity->isDir()) $dirs[] = $entity; else $files[] = $entity;
			}

			# Sort arrays

			$sort = function(Entity $a, Entity $b) {

				return strcmp(Str::toLower($a->getName()), Str::toLower($b->getName()));
			};

			usort($dirs, $sort); usort($files, $sort);

			# Extract a set of items to display

			$items = array_merge($dirs, $files); $total = count($items);

			if (($index > 0) && ($display > 0)) $items = array_splice($items, (($index - 1) * $display), $display);

			# Set properties

			$this->index = $index; $this->display = $display; $this->items = $items; $this->total = $total;

			# ------------------------

			return $this;
		}

		/**
		 * Get the page index
		 */

		public function getIndex() : int {

			return $this->index;
		}

		/**
		 * Get the number of results per page
		 */

		public function getDisplay() : int {

			return $this->display;
		}

		/**
		 * Get the items list
		 */

		public function getItems() : array {

			return $this->items;
		}

		/**
		 * Get the total number of items
		 */

		public function getTotal() : int {

			return $this->total;
		}
	}
}
