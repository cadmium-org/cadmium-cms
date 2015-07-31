<?php

namespace DB\Query {

	use DB\Utils, Number;

	class Select extends Utils\Query {

		# Constructor

		public function __construct($table, $selection, $condition = false, $order = false, $limit = false, $group = false) {

			# Process arguments

			$table = $this->getTableName($table);

			$selection = $this->getFieldset($selection, false, 'name', '', ', ');

			$condition = $this->getFieldset($condition, 'name', 'value', ' = ', ' AND ');

			$order = $this->getFieldset($order, 'name', 'sort', ' ', ', ');

			$limit = Number::unsigned($limit);

			$group = $this->getFieldset($group, false, 'name', '', ' AND ');

			# Build query

			$this->query = ('SELECT ' . $selection . ' FROM ' . $table . ($condition ? (' WHERE (' .  $condition . ')') : '') .

				($group ? (' GROUP BY ' .  $group) : '') . ($order ? (' ORDER BY ' .  $order) : '') . ($limit ? (' LIMIT ' .  $limit) : ''));
		}
	}
}
