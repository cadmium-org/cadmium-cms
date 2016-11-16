<?php

/**
 * @package Framework\Cookie
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Cookie {

		/**
		 * Set a cookie. For more information see http://php.net/manual/function.setcookie.php
		 *
		 * @return true on success or false if output exists prior to calling this method
		 */

		public static function set(string $name, string $value, int $lifetime = 0,

			string $path = '/', string $domain = '', bool $secure = false, bool $http_only = false) : bool {

			return setcookie($name, $value, (REQUEST_TIME + $lifetime), $path, $domain, $secure, $http_only);
		}

		/**
		 * Check if a cookie exists
		 */

		public static function exists(string $name) : bool {

			return isset($_COOKIE[$name]);
		}

		/**
		 * Get a cookie
		 *
		 * @return the value or false if the cookie is not set
		 */

		public static function get(string $name) {

			return ($_COOKIE[$name] ?? false);
		}

		/**
		 * Delete a cookie
		 */

		public static function delete(string $name) {

			if (isset($_COOKIE[$name])) unset($_COOKIE[$name]);
		}
	}
}
