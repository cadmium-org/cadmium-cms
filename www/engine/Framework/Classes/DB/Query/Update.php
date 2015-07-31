<?php

namespace DB\Query {

	use DB\Utils;

	class Update extends Utils\Query {

		# Constructor

		public function __construct($table, $set, $condition = false) {

			# Process arguments

			$table = $this->getName($table);

			$set = $this->getString($set, 'name', 'value', ' = ', ', ');

			$condition = $this->getString($condition, 'name', 'value', ' = ', ' AND ');

			# Build query

			$this->query = ('UPDATE ' . $table . ' SET ' . $set . ($condition ? (' WHERE (' .  $condition . ')') : ''));
		}
	}
}
