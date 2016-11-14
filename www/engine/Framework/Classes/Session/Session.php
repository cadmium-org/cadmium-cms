<?php

/**
 * @package Framework\Session
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Session {

		/**
		 * Start a session
		 *
		 * @return true on success or false on failure
		 */

		public static function start(string $name, int $lifetime) {

			if (session_id()) return true;

			ini_set('session.gc_maxlifetime', $lifetime);

			session_name($name); session_set_cookie_params($lifetime, '/');

			session_cache_expire(0); session_cache_limiter('nocache');

			# ------------------------

			return @session_start();
		}

		/**
		 * Destroy a session
		 */

		public static function destroy() {

			if (session_id()) { session_unset(); session_destroy(); $_SESSION = []; }
		}

		/**
		 * Set a variable
		 */

		public static function set(string $name, $value) {

			if (session_id()) $_SESSION[$name] = $value;
		}

		/**
		 * Check if a variable exists
		 */

		public static function exists(string $name) {

			return isset($_SESSION[$name]);
		}

		/**
		 * Get a variable
		 *
		 * @return the value or null if the variable is not set
		 */

		public static function get(string $name) {

			return ($_SESSION[$name] ?? null);
		}

		/**
		 * Delete a variable
		 */

		public static function delete(string $name) {

			if (isset($_SESSION[$name])) unset($_SESSION[$name]);
		}
	}
}
