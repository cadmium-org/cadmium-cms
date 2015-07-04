<?php

namespace Template\Utils {

	use Template;

	class Group {

		private $blocks = array(), $count = 0;

		# Add block

		public function add($block) {

			if (!Template::settable($block)) return false;

			$this->blocks[] = $block; $this->count++;

			# ------------------------

			return true;
		}

		# Get contents

		public function contents() {

			$contents = '';

			foreach ($this->blocks as $block) $contents .= $block->contents();

			# ------------------------

			return $contents;
		}

		# Return blocks count

		public function count() {

			return $this->count;
		}
	}
}

?>
