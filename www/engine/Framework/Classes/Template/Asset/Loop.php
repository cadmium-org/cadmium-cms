<?php

namespace Template\Utils {

	class Loop {

		private $block = null, $range = [], $separator = '';

		# Constructor

		public function __construct(Block $block) {

			$this->block = $block;
		}

		# Add item to range

		public function add(array $item) {

			$this->range[] = $item;
		}

		# Set range

		public function range(array $range) {

			$this->range = $range;
		}

		# Set separator

		public function separator(string $separator) {

			$this->separator = $separator;
		}

		# Get contents

		public function contents() {

			$group = new Group(); $added = 0; $total = count($this->range);

			foreach ($this->range as $item) {

				$group->add($block = clone($this->block)); $added++;

				# Set variables

				if (is_array($item)) foreach ($item as $name => $value) $block->set($name, $value);

				# Add separator

				if (('' !== $this->separator) && ($added < $total)) $group->add(new Block($this->separator, false));
			}

			# ------------------------

			return $group->contents();
		}
	}
}
