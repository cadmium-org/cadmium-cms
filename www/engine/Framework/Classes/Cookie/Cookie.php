<?php

namespace {

	abstract class Cookie {

		# Set variable

		public static function set($name, $value, $expire = 0, $path = '/', $domain = false, $secure = false, $http_only = false) {

			$name = strval($name); $value = strval($value); $expire = (REQUEST_TIME + intabs($expire));

			$path = strval($path); $domain = strval($domain); $secure = boolval($secure); $http_only = boolval($http_only);

			# ------------------------

			return setcookie($name, $value, $expire, $path, $domain, $secure, $http_only);
		}

		# Check if variable exists

		public static function exists($name) {

			$name = strval($name);

			return isset($_COOKIE[$name]);
		}

		# Get variable

		public static function get($name) {

			$name = strval($name);

			return (isset($_COOKIE[$name]) ? $_COOKIE[$name] : null);
		}

		# Delete variable

		public static function delete($name) {

			$name = strval($name);

			if (isset($_COOKIE[$name])) unset($_COOKIE[$name]);
		}
	}
}
