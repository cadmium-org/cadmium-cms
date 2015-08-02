<?php

namespace DB\Query {

	use DB\Utils;

	class Delete extends Utils\Query {

		# Constructor

		public function __construct($table, $condition = null) {

			# Process arguments

			$table = $this->getName($table);

			$condition = $this->getString($condition, 'name', 'value', ' = ', ' AND ');

			# Build query

			$this->query = ('DELETE FROM ' . $table . ($condition ? (' WHERE (' .  $condition . ')') : ''));
		}
	}
}
