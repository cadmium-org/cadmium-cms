<?php

/**
 * @package Framework\DB
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace DB\Query {

	use DB;

	class Delete extends DB\Query {

		/**
		 * Constructor
		 */

		public function __construct(string $table, $condition = null) {

			# Process arguments

			$table = $this->getName($table);

			$condition = $this->getString($condition, '^name = $value', ' AND ');

			# Build query

			$this->query = ('DELETE FROM ' . $table . ($condition ? (' WHERE (' .  $condition . ')') : ''));
		}
	}
}
