<?php

namespace DB\Query {

	use DB\Utils;

	class Insert extends Utils\Query {

		# Constructor

		public function __construct($table, array $dataset, $multiple = false) {

			# Process arguments

			$table = $this->getName($table); $multiple = boolval($multiple);

			$dataset = (!$multiple ? array($dataset) : array_values($dataset));

			# Process dataset

			$names = array(); $values = array();

			foreach ($dataset as $key => $row) {

				if (0 === $key) $names = $this->getString(array_keys($row), null, 'name', '', ', ');

				$values[] = ('(' . $this->getString(array_values($row), null, 'value', '', ', ') . ')');
			}

			# Build query

			$this->query = ('INSERT INTO ' . $table . ' (' . $names . ') VALUES ' . implode(', ', $values));
		}
	}
}
