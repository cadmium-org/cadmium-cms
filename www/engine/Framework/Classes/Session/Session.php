<?php

namespace {

	abstract class Session {

		# Start session

		public static function start($name, $lifetime) {

			if (session_id()) return true;

			$name = strval($name); $lifetime = intabs($lifetime);

			ini_set('session.gc_maxlifetime', $lifetime);

			ini_set('session.cache_expire', 0); ini_set('session.cache_limiter', 'nocache');

			session_cache_expire(0); session_cache_limiter('nocache');

			session_name($name); session_set_cookie_params($lifetime, '/');

			# ------------------------

			return @session_start();
		}

		# Destroy session

		public static function destroy() {

			if (session_id()) { session_unset(); session_destroy(); $_SESSION = []; }
		}

		# Check if variable exists

		public static function exists($name) {

			$name = strval($name);

			return (session_id() && isset($_SESSION[$name]));
		}

		# Get variable

		public static function get($name) {

			$name = strval($name);

			return ((session_id() && isset($_SESSION[$name])) ? $_SESSION[$name] : false);
		}

		# Set variable

		public static function set($name, $value) {

			$name = strval($name);

			if (session_id()) $_SESSION[$name] = $value;
		}

		# Delete variable

		public static function delete($name) {

			$name = strval($name);

			if (session_id() && isset($_SESSION[$name])) unset($_SESSION[$name]);
		}
	}
}
