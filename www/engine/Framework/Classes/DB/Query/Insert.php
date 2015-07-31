<?php

namespace DB\Query {

	use DB\Utils, Validate;

	class Insert extends Utils\Query {

		# Constructor

		public function __construct($table, array $dataset, $multiple = false) {

			# Process arguments

			$table = $this->getName($table); $multiple = Validate::boolean($multiple);

			$dataset = (!$multiple ? array($dataset) : array_values($dataset));

			$names = array(); $rows = array();

			foreach ($dataset as $key => $row) {

				if (0 === $key) $names = $this->getString(array_keys($row), false, 'name', '', ', ');

				$rows[] = ('(' . $this->getString(array_values($row), false, 'value', '', ', ') . ')');
			}

			# Build query

			$this->query = ('INSERT INTO ' . $table . ' (' . $names . ') VALUES ' . implode(', ', $rows));
		}
	}
}
