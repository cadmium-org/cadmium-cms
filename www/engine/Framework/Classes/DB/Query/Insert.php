<?php

namespace DB\Query {

	use DB\Utils, Validate;

	class Insert extends Utils\Query {

		# Constructor

		public function __construct($table, array $dataset, $multiple = false) {

			# Process arguments

			$table = $this->getName($table); $multiple = Validate::boolean($multiple);

			$dataset = (!$multiple ? array($dataset) : array_values($dataset));

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
