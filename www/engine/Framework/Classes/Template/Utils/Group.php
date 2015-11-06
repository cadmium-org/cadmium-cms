<?php

namespace Template\Utils {

	class Group implements Settable {

		private $blocks = [], $count = 0;

		# Add block

		public function add(Settable $block) {

			$this->blocks[] = $block; $this->count++;

			return true;
		}

		# Get contents

		public function contents(bool $format = true) {

			$contents = '';

			foreach ($this->blocks as $block) $contents .= $block->contents($format);

			# ------------------------

			return $contents;
		}

		# Return blocks count

		public function count() {

			return $this->count;
		}
	}
}
