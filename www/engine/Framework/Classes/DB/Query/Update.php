<?php

/**
 * @package Framework\DB
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace DB\Query {

	use DB;

	class Update extends DB\Query {

		/**
		 * Constructor
		 */

		public function __construct(string $table, array $set, $condition = null) {

			# Process arguments

			$table = $this->getName($table);

			$set = $this->getString($set, '^name = $value', ', ');

			$condition = $this->getString($condition, '^name = $value', ' AND ');

			# Build query

			$this->query = ('UPDATE ' . $table . ' SET ' . $set . ($condition ? (' WHERE (' .  $condition . ')') : ''));
		}
	}
}
