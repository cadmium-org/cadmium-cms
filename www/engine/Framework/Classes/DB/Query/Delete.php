<?php

namespace DB\Query {

	use DB\Utils, String;

	class Delete extends Utils\Query {

		# Constructor

		public function __construct($table, $condition = false) {

			$table = $this->getTableName($table); $condition = $this->getCondition($condition);

			$this->query = ('DELETE FROM ' . $table . ($condition ? (' WHERE (' .  $condition . ')') : ''));
		}
	}
}
