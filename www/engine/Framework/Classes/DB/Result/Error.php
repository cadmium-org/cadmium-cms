<?php

namespace DB\Result {
	
	use DB\Utils;
	
	class Error extends Utils\Result {
		
		protected $error = false, $errno = false;
		
		# Constructor
		
		public function __construct($link, $query, $time) {
			
			$this->status 		= false;
			
			$this->query 		= $query;
			
			$this->result 		= false;
			
			$this->time			= $time;
			
			$this->rows			= 0;
			
			$this->error 		= mysqli_error($link);
			
			$this->errno 		= mysqli_errno($link);
		}
	}
}

?>