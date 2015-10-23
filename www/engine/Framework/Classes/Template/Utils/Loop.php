<?php

namespace Template\Utils {

	class Loop {

		private $block = null, $range = [], $separator = '';

		# Constructor

		public function __construct(Block $block) {

			$this->block = $block;
		}

		# Set range

		public function set(array $range) {

			$this->range = $range;
		}

		# Get contents

		public function contents() {

			$group = new Group();

			foreach ($this->range as $item) {

				if (!is_array($item)) continue;

				$group->add($block = clone($this->block));

				foreach ($item as $name => $value) $block->set($name, $value);
			}

			# ------------------------

			return $group->contents();
		}
	}
}
