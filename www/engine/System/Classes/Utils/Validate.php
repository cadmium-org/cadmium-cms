<?php

namespace Utils {

	use Str;

	class Validate extends \Validate {

		# Validate auth code

		public static function authCode(string $value) {

			return (preg_match(REGEX_USER_AUTH_CODE, $value) ? $value : false);
		}

		# Validate user name

		public static function userName(string $value) {

			$min = CONFIG_USER_NAME_MIN_LENGTH; $max = CONFIG_USER_NAME_MAX_LENGTH;

			return ((preg_match(REGEX_USER_NAME, $value) && Str::between($value, $min, $max)) ? $value : false);
		}

		# Validate user password

		public static function userPassword(string $value) {

			$min = CONFIG_USER_PASSWORD_MIN_LENGTH; $max = CONFIG_USER_PASSWORD_MAX_LENGTH;

			return ((preg_match(REGEX_USER_PASSWORD, $value) && Str::between($value, $min, $max)) ? $value : false);
		}

		# Validate user email

		public static function userEmail(string $value) {

			return self::email($value);
		}

		# Validate template component name

		public static function templateComponentName(string $value) {

			return (preg_match(REGEX_TEMPLATE_COMPONENT_NAME, $value) ? $value : false);
		}

		# Validate file or directory name

		public static function fileName(string $value) {

			return (preg_match(REGEX_FILE_NAME, $value) ? $value : false);
		}

		# Validate url

		public static function url(string $value) {

			if (false === ($value = parent::url($value))) return false;

			if (!preg_match('/^https?:\/\//', $value)) return false;

			# ------------------------

			return rtrim($value, '/');
		}
	}
}
