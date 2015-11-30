<?php

namespace DB\Query {

	use DB\Utils;

	class Select extends Utils\Query {

		# Constructor

		public function __construct(string $table, $selection, $condition = null, $order = null, int $limit = 0) {

			# Process arguments

			$table = $this->getName($table);

			$selection = $this->getString($selection, '$name', ', ');

			$condition = $this->getString($condition, '^name = $value', ' AND ');

			$order = $this->getString($order, '^name $sort', ', ');

			# Build query

			$this->query = ('SELECT ' . $selection . ' FROM ' . $table . ($condition ? (' WHERE (' .  $condition . ')') : '') .

				($order ? (' ORDER BY ' .  $order) : '') . ($limit ? (' LIMIT ' .  $limit) : ''));
		}
	}
}
