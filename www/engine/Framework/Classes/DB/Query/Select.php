<?php

namespace DB\Query {

	use DB\Utils, Number;

	class Select extends Utils\Query {

		# Constructor

		public function __construct($table, $selection, $condition = null, $order = null, $limit = 0) {

			# Process arguments

			$table = $this->getName($table);

			$selection = $this->getString($selection, null, 'name', '', ', ');

			$condition = $this->getString($condition, 'name', 'value', ' = ', ' AND ');

			$order = $this->getString($order, 'name', 'sort', ' ', ', ');

			$limit = Number::unsigned($limit);

			# Build query

			$this->query = ('SELECT ' . $selection . ' FROM ' . $table . ($condition ? (' WHERE (' .  $condition . ')') : '') .

				($order ? (' ORDER BY ' .  $order) : '') . ($limit ? (' LIMIT ' .  $limit) : ''));
		}
	}
}
