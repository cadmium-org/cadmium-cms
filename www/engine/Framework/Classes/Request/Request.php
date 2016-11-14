<?php

/**
 * @package Framework\Request
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Request {

		/**
		 * Check whether this is an ajax request
		 */

		public static function isAjax() {

			return (getenv('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest');
		}

		/**
		 * Check whether this is a HTTPS request
		 */

		public static function isSecure() {

			$https = (!empty(getenv('HTTPS')) && (getenv('HTTPS') !== 'off'));

			return ($https || (getenv('SERVER_PORT') === '443'));
		}

		/**
		 * Get a GET-param value
		 *
		 * @return the value or false if the param does not exist
		 */

		public static function get(string $name) {

			return ($_GET[$name] ?? false);
		}

		/**
		 * Get a POST-param value
		 *
		 * @return the value or false if the param does not exist
		 */

		public static function post(string $name) {

			return ($_POST[$name] ?? false);
		}

		/**
		 * Get a FILE-param value
		 *
		 * @return the array with file info or false if the param does not exist
		 */

		public static function file(string $name) {

			return ($_FILES[$name] ?? false);
		}

		/**
		 * Redirect to a specified url and terminate the script
		 */

		public static function redirect(string $url) {

			header("Location: " . $url); exit();
		}
	}
}
