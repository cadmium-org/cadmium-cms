<?php

namespace System\Utils\Map {
	
	use String;
	
	class Item {
		
		private $path = array(), $handler = array(), $status = false;
		
		# Parse path string
		
		private function parsePath($path) {
			
			$path = String::validate($path);
			
			if (!preg_match('/^\/(.*)$/', $path, $matches)) return false;
			
			$path_array = preg_split('/\//', $matches[1], 0, PREG_SPLIT_NO_EMPTY); $path_parsed = array();
			
			foreach ($path_array as $name) {
				
				if (!preg_match(REGEX_MAP_PATH_ITEM_NAME, $name)) return false;
				
				$path_parsed[] = $name;
			}
			
			$this->path = $path_parsed;
			
			# ------------------------
			
			return true;
		}
		
		# Parse handler string
		
		private function parseHandler($handler) {
			
			$handler = String::validate($handler);
			
			if (!preg_match('/^\/(.*)$/', $handler, $matches)) return false;
			
			$handler_array = preg_split('/\//', $matches[1], 0, PREG_SPLIT_NO_EMPTY); $handler_parsed = array();
			
			foreach ($handler_array as $name) {
				
				if (!preg_match(REGEX_MAP_HANDLER_ITEM_NAME, $name)) return false;
				
				$handler_parsed[] = $name;
			}
			
			$this->handler = $handler_parsed;
			
			# ------------------------
			
			return true;
		}
		
		# Constructor
		
		public function __construct($path, $handler) {
			
			$path_status = $this->parsePath($path); $handler_status = $this->parseHandler($handler);
			
			$this->status = ($path_status && $handler_status);
		}
		
		# Get handler by path
		
		public function handler($path) {
			
			if (!$this->status || !is_array($path)) return false;
			
			if ($path !== $this->path) return false;
			
			# ------------------------
			
			return implode('\\', $this->handler);
		}
		
		# Return status
		
		public function status() {
			
			return $this->status;
		}
	}
}

?>