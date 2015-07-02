<?php

namespace Geo {
	
	use Explorer, String;
	
	abstract class Country {
		
		private static $countries = false;
		
		# Autoloader
		
		public static function __autoload() {
			
			self::$countries = Explorer::php(DIR_DATA . 'Geo/Countries.php');
		}
		
		# Check if country exists
		
		public static function exists($code) {
			
			$code = String::validate($code);
			
			return (isset(self::$countries[$code]) ? true : false);
		}
		
		# Validate code
		
		public static function validate($code) {
			
			$code = String::validate($code);
			
			return (self::exists($code) ? $code : false);
		}
		
		# Get country by code
		
		public static function get($code) {
			
			$code = String::validate($code);
			
			return (isset(self::$countries[$code]) ? self::$countries[$code] : false);
		}
		
		# Get list
		
		public static function range() {
			
			return self::$countries;
		}
	}
}

?>