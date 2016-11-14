<?php

namespace Template {

	class Loop {

		private $block = null, $items = null;

		/**
		 * Constructor
		 */

		public function __construct(string $contents = '') {

			$this->block = new Block($contents); $this->items = new Block;
		}

		/**
		 * Add an item
		 *
		 * @return the current loop object
		 */

		public function addItem(array $data) {

			$this->items->addItem((clone $this->block)->setArray($data));

			return $this;
		}

		/**
		 * Add multiple items
		 *
		 * @return the current loop object
		 */

		public function addItems(array $items) {

			foreach ($items as $item) if (is_array($item)) $this->addItem($item);

			return $this;
		}

		/**
		 * Clear the items list
		 *
		 * @return the current loop object
		 */

		public function removeItems() {

			$this->items->removeItems();

			return $this;
		}

		/**
		 * Set items list
		 *
		 * @return the current loop object
		 */

		public function setItems(array $items) {

			$this->removeItems(); $this->addItems($items);

			return $this;
		}

		/**
		 * Get the items list
		 */

		public function getItems() {

			return $this->items->getItems();
		}

		/**
		 * Get the items count
		 */

		public function getCount() {

			return $this->items->getCount();
		}

		/**
		 * Get the loop contents
		 */

		public function getContents() {

			return $this->items->getContents();
		}
	}
}
