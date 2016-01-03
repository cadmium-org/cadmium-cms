<?php

namespace DB\Query {

	use DB\Utils;

	class Update extends Utils\Query {

		# Constructor

		public function __construct(string $table, array $dataset, $condition = null) {

			# Process arguments

			$table = $this->getName($table);

			$dataset = $this->getString($dataset, '^name = $value', ', ');

			$condition = $this->getString($condition, '^name = $value', ' AND ');

			# Build query

			$this->query = ('UPDATE ' . $table . ' SET ' . $dataset . ($condition ? (' WHERE (' .  $condition . ')') : ''));
		}
	}
}
