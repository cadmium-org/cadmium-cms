<?php

/**
 * @package Cadmium\Framework\Request
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Request {

		/**
		 * Check whether this is an ajax request
		 */

		public static function isAjax() : bool {

			return (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest');
		}

		/**
		 * Check whether this is a special ajax request
		 */

		public static function isSpecial(string $type) : bool {

			return (self::isAjax() && ($_SERVER['HTTP_X_SPECIAL_REQUEST'] ?? null) === $type);
		}

		/**
		 * Check whether this is a HTTPS request
		 */

		public static function isSecure() : bool {

			$https = (!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] !== 'off'));

			return ($https || ($_SERVER['SERVER_PORT'] === '443'));
		}

		/**
		 * Get a GET-param value
		 *
		 * @return string|false : the value or false if the param does not exist
		 */

		public static function get(string $name) {

			return ($_GET[$name] ?? false);
		}

		/**
		 * Get a POST-param value
		 *
		 * @return string|false : the value or false if the param does not exist
		 */

		public static function post(string $name) {

			return ($_POST[$name] ?? false);
		}

		/**
		 * Get a FILE-param value
		 *
		 * @return array|false : the array with file info or false if the param does not exist
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
