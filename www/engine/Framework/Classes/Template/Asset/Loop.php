<?php

namespace Template\Asset {

	class Loop {

		private $block = null, $range = [];

		# Constructor

		public function __construct(string $contents = '') {

			$this->block = new Block($contents);
		}

		# Set range

		public function range(array $range) {

			$this->range = $range;
		}

		# Add item to range

		public function add(array $item) {

			$this->range[] = $item;
		}

		# Get contents

		public function contents() {

			$group = new Group();

			foreach ($this->range as $item) {

				$group->add($block = clone($this->block));

				if (is_array($item)) foreach ($item as $name => $value) if (is_scalar($value)) $block->set($name, $value);
			}

			# ------------------------

			return $group->contents();
		}
	}
}
