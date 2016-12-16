<?php

/**
 * @package Cadmium\Framework\DB
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace DB\Query {

	use DB;

	class Count extends DB\Query {

		/**
		 * Constructor
		 */

		public function __construct(string $table, string $column = '*', bool $distinct = false, $condition = null) {

			# Process arguments

			$table = $this->getName($table);

			if ($column !== '*') $column = (($distinct ? 'DISTINCT ' : '') . $this->getName($column));

			$condition = $this->getString($condition, '^name = $value', ' AND ');

			# Build query

			$this->query = ('SELECT COUNT(' . $column . ') as count ' .

				'FROM ' . $table . ($condition ? (' WHERE (' .  $condition . ')') : ''));
		}
	}
}
