<?php

namespace Template\Asset {

	class Group extends Block {

		private $items = [], $count = 0;

		# Constructor

		public function __construct() {}

		# Add item

		public function add(Block $item) {

			$this->items[] = $item; $this->count++;
		}

		# Get contents

		public function contents() {

			$contents = '';

			foreach ($this->items as $block) $contents .= $block->contents();

			# ------------------------

			return $contents;
		}

		# Return items count

		public function count() {

			return $this->count;
		}
	}
}
