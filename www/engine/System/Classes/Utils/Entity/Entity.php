<?php

namespace System\Utils\Entity {

	use DB, Number;

	class Entity {

		protected $entity = false, $params = false;

		protected $table = false, $nesting = false, $super = false;

        # Constructor

        public function __construct() {

            $this->params = new Params();

            # Define entity params

            $this->define();
        }

		# Create table

		public function createTable() {

            $set = array_merge($this->params->fieldset(), $this->params->keyset());

            $query = ("CREATE TABLE IF NOT EXISTS `" . $this->table . "`") .

                     ("(" . implode(", ", $set) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8");

            # ------------------------

            return (DB::send($query) && DB::last()->status);
		}
	}
}

?>
