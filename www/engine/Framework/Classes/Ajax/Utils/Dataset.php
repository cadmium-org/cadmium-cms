<?php

namespace Ajax\Utils {

	class Dataset {

		private $data = [], $status = true;

		# Set variable

		public function set($name, $value) {

			$name = strval($name); $value = strval($value);

			$this->data[$name] = $value;

			# ------------------------

    		return $this;
		}

    	# Set error

    	public function error($value = null) {

    		if (null !== $value) $this->set('error', $value);

			$this->status = false;

			# ------------------------

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
