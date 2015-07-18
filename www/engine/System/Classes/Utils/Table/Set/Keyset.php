<?php

namespace System\Utils\Table\Set {

	use String;

	class Keyset {

		private $keyset = false;

        # Add primary key

        public function primary($name) {

            $name = String::validate($name);

            $this->keyset[] = ("PRIMARY KEY (`" . $name . "`)");
        }

        # Add unique key

        public function unique($name) {

            $name = String::validate($name);

            $this->keyset[] = ("UNIQUE KEY `" . $name . "` (`" . $name . "`)");
        }

        # Add index

        public function index($name) {

            $name = String::validate($name);

            $this->keyset[] = ("KEY `" . $name . "` (`" . $name . "`)");
        }

        # Return array

        public function get() {

            return $this->keyset;
        }
    }
}

?>
