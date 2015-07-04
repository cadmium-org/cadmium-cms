<?php

namespace DB\Query {

	use DB\Utils, Number, String;

	class Select extends Utils\Query {

		# Get selection

		private function getSelection($source) {

			if (!is_array($source)) return String::validate($source);

			$selection = array();

			foreach ($source as $name) {

				if (count($split = preg_split('/[ ]as[ ]/', $name, 2)) === 2) {

					$selection[] = ($this->getFieldName($split[0]) . ' as ' . $this->getAliasName($split[1]));

				} else $selection[] = $this->getFieldName($name);
			}

			return implode(', ', $selection);
		}

		# Get condition

		private function getCondition($source) {

			if (!is_array($source)) return String::validate($source);

			$condition = array();

			foreach ($source as $name => $value) $condition[] = ($this->getFieldName($name) . ' = ' . $this->getFieldValue($value));

			# ------------------------

			return implode(' AND ', $condition);
		}

		# Get order

		private function getOrder($source) {

			if (!is_array($source)) return String::validate($source);

			$order = array();

			foreach ($source as $name => $sort) $order[] = ($this->getFieldName($name) . ' ' . $this->getFieldSort($sort));

			# ------------------------

			return implode(', ', $order);
		}

		# Get group

		private function getGroup($source) {

			if (!is_array($source)) return String::validate($source);

			$group = array();

			foreach ($source as $name) $group[] = $this->getFieldName($name);

			# ------------------------

			return implode(', ', $group);
		}

		# Constructor

		public function __construct($table, $selection, $condition = false, $order = false, $limit = false, $group = false) {

			$table = $this->getTableName($table); $selection = $this->getSelection($selection); $condition = $this->getCondition($condition);

			$order = $this->getOrder($order); $limit = Number::unsigned($limit); $group = $this->getGroup($group);

			$this->query = ('SELECT ' . $selection . ' FROM ' . $table . ($condition ? (' WHERE (' .  $condition . ')') : '') .

				($group ? (' GROUP BY ' .  $group) : '') . ($order ? (' ORDER BY ' .  $order) : '') . ($limit ? (' LIMIT ' .  $limit) : ''));
		}
	}
}

?>
