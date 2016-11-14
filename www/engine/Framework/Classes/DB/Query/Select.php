<?php

/**
 * @package Framework\DB\Query
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace DB\Query {

	use DB;

	class Select extends DB\Query {

		/**
		 * Constructor
		 */

		public function __construct(string $table, $selection, $condition = null, $order = null, int $limit = 0) {

			# Process arguments

			$table = $this->getName($table);

			$selection = $this->getString($selection, '$name', ', ');

			$condition = $this->getString($condition, '^name = $value', ' AND ');

			$order = $this->getString($order, '^name $direction', ', ');

			# Build query

			$this->query = ('SELECT ' . $selection . ' FROM ' . $table . ($condition ? (' WHERE (' .  $condition . ')') : '') .

				($order ? (' ORDER BY ' .  $order) : '') . ($limit ? (' LIMIT ' .  $limit) : ''));
		}
	}
}
