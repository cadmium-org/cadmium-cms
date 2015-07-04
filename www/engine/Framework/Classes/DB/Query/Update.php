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

		# Get condition

		private function getCondition($source) {

			if (!is_array($source)) return String::validate($source);

			$condition = array();

			foreach ($source as $name => $value) $condition[] = ($this->getFieldName($name) . ' = ' . $this->getFieldValue($value));

			# ------------------------

			return implode(' AND ', $condition);
		}

		# Constructor

		function __construct($table, $set, $condition = false) {

			$table = $this->getTableName($table); $set = $this->getDataset($set); $condition = $this->getCondition($condition);

			$this->query = ('UPDATE ' . $table . ' SET ' . $set . ($condition ? (' WHERE (' .  $condition . ')') : ''));
		}
	}
}

?>
