<?php

namespace DB\Utils {
	
	abstract class Result {
		
		protected $status = false, $query = false, $result = false, $time = false, $rows = false;
		
		# Getter
		
		public function __get($var) {
			
			return (isset($this->$var) ? $this->$var : null);
		}
	}
}

?>