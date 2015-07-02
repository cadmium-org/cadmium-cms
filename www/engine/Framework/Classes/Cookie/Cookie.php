<?php

namespace {
	
	abstract class Cookie {
		
		# Set variable
		
		public static function set($name, $value, $expire = 0, $path = '/', $domain = false, $secure = false, $http_only = false) {
			
			$name = String::validate($name); $value = String::validate($value);
			
			$expire = (ENGINE_TIME + Number::unsigned($expire));
			
			$path = String::validate($path); $domain = String::validate($domain);
			
			$secure = Validate::boolean($secure); $http_only = Validate::boolean($http_only);
			
			# ------------------------
			
			return setcookie($name, $value, $expire, $path, $domain, $secure, $http_only);
		}
		
		# Get variable
		
		public static function get($name) {
			
			$name = String::validate($name);
			
			return (isset($_COOKIE[$name]) ? $_COOKIE[$name] : null);
		}
		
		# Check if variable exists
		
		public static function exists($name) {
			
			$name = String::validate($name);
			
			return (isset($_COOKIE[$name]) ? true : false);
		}
		
		# Delete variable
		
		public static function delete($name) {
			
			$name = String::validate($name);
			
			if (isset($_COOKIE[$name])) unset($_COOKIE[$name]);
		}
	}
}

?>