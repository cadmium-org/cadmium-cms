<?php

/**
 * @package Framework\DB\Query
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace DB\Query {

	use DB;

	class Insert extends DB\Query {

		/**
		 * Constructor
		 */

		public function __construct(string $table, array $set, bool $multiple = false, bool $ignore = false) {

			# Process arguments

			$table = $this->getName($table);

			$set = ($multiple ? array_values($set) : [$set]);

			# Process set

			$names = ''; $values = [];

			foreach ($set as $key => $row) if (is_array($row)) {

				if (0 === $key) $names = $this->getString(array_keys($row), '$name', ', ');

				$values[] = ('(' . $this->getString(array_values($row), '$value', ', ') . ')');
			}

			# Build query

			$this->query = ('INSERT ' . ($ignore ? 'IGNORE ' : '') .

				'INTO ' . $table . ' (' . $names . ') VALUES ' . implode(', ', $values));
		}
	}
}
