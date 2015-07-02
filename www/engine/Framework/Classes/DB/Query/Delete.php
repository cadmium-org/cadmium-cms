<?php

namespace DB\Query {
	
	use DB\Utils, String;
	
	class Delete extends Utils\Query {
		
		# Get condition
		
		private function getCondition($source) {
			
			if (!is_array($source)) return String::validate($source);
			
			$condition = array();
			
			foreach ($source as $name => $value) $condition[] = ($this->getFieldName($name) . ' = ' . $this->getFieldValue($value));
			
			# ------------------------
			
			return implode(' AND ', $condition);
		}
		
		# Constructor
		
		public function __construct($table, $condition = false) {
			
			$table = $this->getTableName($table); $condition = $this->getCondition($condition);
			
			$this->query = ('DELETE FROM ' . $table . ($condition ? (' WHERE (' .  $condition . ')') : ''));
		}
	}
}

?>