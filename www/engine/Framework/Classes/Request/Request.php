<?php

namespace {
	
	abstract class Request {
		
		# Check if requested with ajax
		
		public static function isAjax() {
			
			if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) return false;
			
			return (0 === strcmp($_SERVER['HTTP_X_REQUESTED_WITH'], 'XMLHttpRequest'));
		}
		
		# Return GET variable by name
		
		public static function get($name) {
			
			$name = String::validate($name);
			
			return (isset($_GET[$name]) ? String::validate($_GET[$name]) : null);
		}
		
		# Return POST variable by name
		
		public static function post($name) {
			
			$name = String::validate($name);
			
			return (isset($_POST[$name]) ? String::validate($_POST[$name]) : null);
		}
		
		# Redirect to specified url
		
		public static function redirect($url) {
			
			$url = String::validate($url);
			
			header("Location: " . $url); exit();
		}
	}
}

?>