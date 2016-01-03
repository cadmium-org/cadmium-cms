<?php

namespace System\Modules\Entitizer\Utils {

	abstract class Param {

		protected $name = '', $index = false, $unique = false, $primary = false;

		# Return name

		public function name() {

			return $this->name;
		}

		# Check if param is index

		public function index() {

			return $this->index;
		}

		# Check if param is unique

		public function unique() {

			return $this->unique;
		}

		# Check if param is primary

		public function primary() {

			return $this->primary;
		}

		# Get key statement

		public function keyStatement() {

			return ($this->index ? (($this->unique ? ($this->primary ? "PRIMARY " : "UNIQUE ") : "") .

			       ("KEY `" . $this->name . "` (`" . $this->name . "`)")) : false);
		}
	}
}
