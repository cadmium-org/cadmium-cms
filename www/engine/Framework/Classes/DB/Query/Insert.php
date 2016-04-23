<?php

namespace DB\Query {

	use DB\Utils;

	class Insert extends Utils\Query {

		# Constructor

		public function __construct(string $table, array $dataset, bool $multiple = false, bool $ignore = false) {

			# Process arguments

			$table = $this->getName($table);

			$dataset = ($multiple ? array_values($dataset) : [$dataset]);

			# Process dataset

			$names = ''; $values = [];

			foreach ($dataset as $key => $row) if (is_array($row)) {

				if (0 === $key) $names = $this->getString(array_keys($row), '$name', ', ');

				$values[] = ('(' . $this->getString(array_values($row), '$value', ', ') . ')');
			}

			# Build query

			$this->query = ('INSERT ' . ($ignore ? 'IGNORE ' : '') .

				'INTO ' . $table . ' (' . $names . ') VALUES ' . implode(', ', $values));
		}
	}
}
