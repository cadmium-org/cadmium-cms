<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils {

	use Str;

	class Validate extends \Validate {

		/**
		 * Validate an authorization code
		 *
		 * @return string|false : the code or false on failure
		 */

		public static function authCode(string $value) {

			return (preg_match(REGEX_USER_AUTH_CODE, $value) ? $value : false);
		}

		/**
		 * Validate a user name
		 *
		 * @return string|false : the name or false on failure
		 */

		public static function userName(string $value) {

			$min = CONFIG_USER_NAME_MIN_LENGTH; $max = CONFIG_USER_NAME_MAX_LENGTH;

			return ((preg_match(REGEX_USER_NAME, $value) && Str::between($value, $min, $max)) ? $value : false);
		}

		/**
		 * Validate a user password
		 *
		 * @return string|false : the password or false on failure
		 */

		public static function userPassword(string $value) {

			$min = CONFIG_USER_PASSWORD_MIN_LENGTH; $max = CONFIG_USER_PASSWORD_MAX_LENGTH;

			return ((preg_match(REGEX_USER_PASSWORD, $value) && Str::between($value, $min, $max)) ? $value : false);
		}

		/**
		 * Validate a user email
		 *
		 * @return string|false : the email or false on failure
		 */

		public static function userEmail(string $value) {

			return self::email($value);
		}

		/**
		 * Validate a template component name
		 *
		 * @return string|false : the name or false on failure
		 */

		public static function templateComponentName(string $value) {

			return (preg_match(REGEX_TEMPLATE_COMPONENT_NAME, $value) ? $value : false);
		}

		/**
		 * Validate a file/directory name
		 *
		 * @return string|false : the name or false on failure
		 */

		public static function fileName(string $value) {

			return (preg_match(REGEX_FILE_NAME, $value) ? $value : false);
		}

		/**
		 * Validate a url
		 *
		 * @return string|false : the url or false on failure
		 */

		public static function url(string $value) {

			if (false === ($value = parent::url($value))) return false;

			if (!preg_match('/^https?:\/\//', $value)) return false;

			# ------------------------

			return rtrim($value, '/');
		}
	}
}
