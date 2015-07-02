<?php

namespace {
	
	abstract class Session {
		
		# Start session
		
		public static function start($name, $lifetime) {
			
			if (session_id()) return true;
			
			$name = String::validate($name); $lifetime = Number::unsigned($lifetime);
			
			ini_set('session.gc_maxlifetime', $lifetime);
			
			ini_set('session.cache_expire', 0); ini_set('session.cache_limiter', 'nocache');
			
			session_cache_expire(0); session_cache_limiter('nocache');
			
			session_name($name); session_set_cookie_params($lifetime, '/');
			
			# ------------------------
			
			return @session_start();
		}
		
		# Destroy session
		
		public static function destroy() {
			
			if (session_id()) { session_unset(); session_destroy(); $_SESSION = array(); }
		}
		
		# Set variable
		
		public static function set($name, $value) {
			
			$name = String::validate($name);
			
			if (session_id()) $_SESSION[$name] = $value;
		}
		
		# Get variable
		
		public static function get($name) {
			
			$name = String::validate($name);
			
			return ((session_id() && isset($_SESSION[$name])) ? $_SESSION[$name] : null);
		}
		
		# Check if variable exists
		
		public static function exists($name) {
			
			$name = String::validate($name);
			
			return ((session_id() && isset($_SESSION[$name])) ? true : false);
		}
		
		# Delete variable
		
		public static function delete($name) {
			
			$name = String::validate($name);
			
			if (session_id() && isset($_SESSION[$name])) unset($_SESSION[$name]);
		}
	}
}

?>