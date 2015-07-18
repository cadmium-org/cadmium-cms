<?php

namespace System\Utils\Table {

	use DB, String;

	class Table {

		private $name = false, $fieldset = false, $keyset = false;

        # Constructor

        public function __construct($name) {

            $this->name = String::validate($name);

            $this->fieldset = new Set\Fieldset(); $this->keyset = new Set\Keyset();
        }

        # Return fieldset

        public function fieldset() {

            return $this->fieldset;
        }

        # Return keyset

        public function keyset() {

            return $this->keyset;
        }

        # Create table

        public function create() {

            if (false === $this->name) return false;

            $set = array_merge($this->fieldset->get(), $this->keyset->get());

            $query = ("CREATE TABLE IF NOT EXISTS `" . $this->name . "`") .

                     ("(" . implode(", ", $set) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8");

            # ------------------------

            return (DB::send($query) && DB::last()->status);
        }
    }
}

?>
