<?php 

namespace DB\Result {
	
	use DB\Utils;
	
	class Affect extends Utils\Result {
		
		protected $id = false;
		
		# Constructor
		
		public function __construct($link, $query, $time) {
			
			$this->status 		= true;
			
			$this->query 		= $query;
			
			$this->result		= true;
			
			$this->time			= $time;
			
			$this->rows			= mysqli_affected_rows($link);
			
			$this->id			= mysqli_insert_id($link);
		}
	}
}

?>