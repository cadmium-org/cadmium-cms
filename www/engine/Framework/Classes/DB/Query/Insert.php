<?php

namespace DB\Query {

	use DB\Utils;

	class Insert extends Utils\Query {

		# Constructor

		public function __construct(string $table, array $dataset, bool $multiple = false) {

			# Process arguments

			$table = $this->getName($table);

			$dataset = (!$multiple ? [$dataset] : array_values($dataset));

			# Process dataset

			$names = []; $values = [];

			foreach ($dataset as $key => $row) {

				if (0 === $key) $names = $this->getString(array_keys($row), '$name', ', ');

				$values[] = ('(' . $this->getString(array_values($row), '$value', ', ') . ')');
			}

			# Build query

			$this->query = ('INSERT INTO ' . $table . ' (' . $names . ') VALUES ' . implode(', ', $values));
		}
	}
}
