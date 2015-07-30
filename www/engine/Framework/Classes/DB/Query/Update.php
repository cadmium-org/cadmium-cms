<?php

namespace DB\Query {

	use DB\Utils, String;

	class Update extends Utils\Query {

		# Get dataset

		private function getDataset(array $source) {

			$dataset = array();

			foreach ($source as $name => $value) $dataset[] = ($this->getFieldName($name) . ' = ' . $this->getFieldValue($value));

			# ------------------------

			return implode(', ', $dataset);
		}

		# Constructor

		public function __construct($table, $set, $condition = false) {

			$table = $this->getTableName($table); $set = $this->getDataset($set); $condition = $this->getCondition($condition);

			$this->query = ('UPDATE ' . $table . ' SET ' . $set . ($condition ? (' WHERE (' .  $condition . ')') : ''));
		}
	}
}
