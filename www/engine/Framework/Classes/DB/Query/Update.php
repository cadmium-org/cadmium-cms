<?php

namespace DB\Query {

	use DB\Utils, Arr, String;

	class Update extends Utils\Query {

		# Get dataset

		private function getDataset($source) {

			$source = Arr::force($source); $dataset = array();

			foreach ($source as $name => $value) $dataset[] = ($this->getFieldName($name) . ' = ' . $this->getFieldValue($value));

			# ------------------------

			return implode(', ', $dataset);
		}

		# Constructor

		function __construct($table, $set, $condition = false) {

			$table = $this->getTableName($table); $set = $this->getDataset($set); $condition = $this->getCondition($condition);

			$this->query = ('UPDATE ' . $table . ' SET ' . $set . ($condition ? (' WHERE (' .  $condition . ')') : ''));
		}
	}
}
