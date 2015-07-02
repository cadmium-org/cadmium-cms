<?php

namespace DB\Utils {
	
	use String;
	
	abstract class Query {
		
		protected $query = false;
		
		# Sanitize name
		
		private function sanitizeName($name) {
			
			return trim(preg_replace('/[^a-zA-Z0-9_]/', '_', $name));
		}
		
		# Get table name
		
		protected function getTableName($name) {
			
			$name = String::validate($name);
			
			return mb_strtolower(self::sanitizeName($name));
		}
		
		# Get alias name
		
		protected function getAliasName($name) {
			
			$name = String::validate($name);
			
			return mb_strtolower(self::sanitizeName($name));
		}
		
		# Get field name
		
		protected function getFieldName($name) {
			
			$name = String::validate($name);
			
			if (preg_match('/^([^\(]+)[ ]*\([ ]*(.+)[ ]*\)$/', trim($name), $matches)) {
				
				$function = mb_strtoupper(self::sanitizeName($matches[1]));
				
				$param = (($matches[2] === '*') ? '*' : mb_strtolower(self::sanitizeName($matches[2])));
				
				return ($function . '(' . $param . ')');
			}
			
			return mb_strtolower(self::sanitizeName($name));
		}
		
		# Get field value
		
		protected function getFieldValue($value) {
			
			$value = String::validate($value);
			
			return ("'" . addslashes($value) . "'");
		}
		
		# Get field sort
		
		protected function getFieldSort($sort) {
			
			$sort = String::validate($sort);
			
			return ((mb_strtoupper($sort) === 'DESC') ? 'DESC' : 'ASC');
		}
		
		# Return query
		
		public function query() {
			
			return $this->query;
		}
	}
}

?>