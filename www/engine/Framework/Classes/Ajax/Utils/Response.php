<?php

namespace Ajax\Utils {

	class Response {

		private $data = [], $status = true;

		# Set variable

		public function set(string $name, $value) {

			if (is_scalar($value)) $this->data[$name] = $value;

			return $this;
		}

		# Set error

		public function error($value) {

			$this->set('error', $value); $this->status = false;

			return $this;
		}

		# Return data

		public function data() {

			return $this->data;
		}

		# Return status

		public function status() {

			return $this->status;
		}
	}
}
