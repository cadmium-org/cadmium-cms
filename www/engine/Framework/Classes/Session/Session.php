<?php

namespace {

	abstract class Session {

		# Start session

		public static function start(string $name, int $lifetime) {

			if (session_id()) return true;

			ini_set('session.gc_maxlifetime', $lifetime);

			session_name($name); session_set_cookie_params($lifetime, '/');

			session_cache_expire(0); session_cache_limiter('nocache');



			# ------------------------

			return @session_start();
		}

		# Destroy session

		public static function destroy() {

			if (session_id()) { session_unset(); session_destroy(); $_SESSION = []; }
		}

		# Check if variable exists

		public static function exists(string $name) {

			return (session_id() && isset($_SESSION[$name]));
		}

		# Get variable

		public static function get(string $name) {

			return ((session_id() && isset($_SESSION[$name])) ? $_SESSION[$name] : false);
		}

		# Set variable

		public static function set(string $name, $value) {

			if (session_id()) $_SESSION[$name] = $value;
		}

		# Delete variable

		public static function delete(string $name) {

			if (session_id() && isset($_SESSION[$name])) unset($_SESSION[$name]);
		}
	}
}
