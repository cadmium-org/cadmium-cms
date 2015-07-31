<?php

namespace DB\Query {

	use DB\Utils;

	class Count extends Utils\Query {

		# Constructor

		public function __construct($table, $condition = false) {

			# Process arguments

			$table = $this->getName($table);

			$condition = $this->getFieldset($condition, 'name', 'value', ' = ', ' AND ');

			# Build query

			$this->query = ('SELECT COUNT(*) FROM ' . $table . ($condition ? (' WHERE (' .  $condition . ')') : ''));
		}
	}
}
