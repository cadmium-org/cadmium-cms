<?php

namespace DB\Query {

	use DB\Utils, Validate;

	class Insert extends Utils\Query {

		# Get single dataset

		private function getSingleDataset(array $source) {

			$names = array(); $values = array();

			foreach ($source as $name => $value) {

				$names[] = $this->getName($name); $values[] = $this->getValue($value);
			}

			return ('(' . implode(', ', $names) . ') VALUES (' . implode(', ', $values) . ')');
		}

		# Get multiple dataset

		private function getMultipleDataset(array $source) {

			$names = array(); $values = array(); $count = 0;

			foreach ($source as $field) {

				$values[$count] = array(); if (!is_array($field)) $field = array();

				foreach ($field as $name => $value) {

					if ($count === 0) $names[] = $this->getName($name);

					$values[$count][] = $this->getValue($value);
				}

				$values[$count] = ('(' .  implode(', ', $values[$count]) . ')'); $count++;
			}

			return ('(' . implode(', ', $names) . ') VALUES ' . implode(', ', $values));
		}

		# Constructor

		public function __construct($table, $dataset, $multiple = false) {

			# Process arguments

			$table = $this->getName($table); $multiple = Validate::boolean($multiple);

			$dataset = (!$multiple ? $this->getSingleDataset($dataset) : $this->getMultipleDataset($dataset));

			# Build query

			$this->query = ('INSERT INTO ' . $table . ' ' . $dataset);
		}
	}
}
