<?php

namespace {

	abstract class Cookie {

		# Set variable

		public static function set(string $name, string $value, int $expire = 0,

			string $path = '/', string $domain = '', bool $secure = false, bool $http_only = false) {

			return setcookie($name, $value, (REQUEST_TIME + $expire), $path, $domain, $secure, $http_only);
		}

		# Check if variable exists

		public static function exists(string $name) {

			return isset($_COOKIE[$name]);
		}

		# Get variable

		public static function get(string $name) {

			return (isset($_COOKIE[$name]) ? $_COOKIE[$name] : false);
		}

		# Delete variable

		public static function delete(string $name) {

			if (isset($_COOKIE[$name])) unset($_COOKIE[$name]);
		}
	}
}
