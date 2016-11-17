<?php

/**
 * @package Framework\Template
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Template {

	class Group {

		protected $items = [], $count = 0;

		/**
		 * Constructor
		 */

		public function __construct() {

			// nothing here
		}

		/**
		 * Cloner
		 */

		public function __clone() {

			foreach ($this->items as $name => $item) $this->items[$name] = clone $item;
		}

		/**
		 * Add an item
		 *
		 * @return Template\Group : the current group object
		 */

		public function addItem(Block $item) : Group {

 			$this->items[] = $item; $this->count++;

 			return $this;
 		}

		/**
		 * Add multiple items
		 *
		 * @return Template\Group : the current group object
		 */

		public function addItems(array $items) : Group {

 			foreach ($items as $item) if ($item instanceof Block) $this->addItem($item);

 			return $this;
 		}

		/**
		 * Clear the items list
		 *
		 * @return Template\Group : the current group object
		 */

		 public function removeItems() : Group {

 			$this->items = []; $this->count = 0;

 			return $this;
 		}

		/**
		 * Set items list
		 *
		 * @return Template\Group : the current group object
		 */

		public function setItems(array $items) : Group {

 			$this->removeItems(); $this->addItems($items);

 			return $this;
 		}

		/**
		 * Get the items list
		 */

		public function getItems() : array {

 			return $this->items;
 		}

		/**
		 * Get the items count
		 */

		 public function getCount() : int {

 			return $this->count;
 		}

		/**
		 * Get the group contents
		 */

		public function getContents() : string {

			$contents = '';

			# Process items

			foreach ($this->items as $block) $contents .= $block->getContents();

			# ------------------------

			return $contents;
		}
	}
}
