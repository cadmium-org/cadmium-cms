<?php

namespace DB\Query {
	
	use DB\Utils, Arr, Validate;
	
	class Insert extends Utils\Query {
		
		# Get single dataset
		
		private function getSingleDataset($source) {
			
			$source = Arr::force($source); $names = array(); $values = array();
			
			foreach ($source as $name => $value) {
				
				$names[] = $this->getFieldName($name); $values[] = $this->getFieldValue($value);
			}
			
			return ('(' . implode(', ', $names) . ') VALUES (' . implode(', ', $values) . ')');
		}
		
		# Get multiple dataset
		
		private function getMultipleDataset($source) {
			
			$source = Arr::force($source); $names = array(); $values = array(); $count = 0;
			
			foreach ($source as $field) {
				
				$values[$count] = array(); if (!is_array($field)) $field = array();
				
				foreach ($field as $name => $value) {
					
					if ($count === 0) $names[] = $this->getFieldName($name);
					
					$values[$count][] = $this->getFieldValue($value);
				}
				
				$values[$count] = ('(' .  implode(', ', $values[$count]) . ')'); $count++;
			}
			
			return ('(' . implode(', ', $names) . ') VALUES ' . implode(', ', $values));
		}
		
		# Constructor
		
		public function __construct($table, $dataset, $multiple = false) {
			
			$table = $this->getTableName($table); $multiple = Validate::boolean($multiple);
			
			$dataset = (!$multiple ? $this->getSingleDataset($dataset) : $this->getMultipleDataset($dataset));
			
			$this->query = ('INSERT INTO ' . $table . ' ' . $dataset);
		}
	}
}

?>