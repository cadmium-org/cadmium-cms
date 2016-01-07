<?php

namespace Utils {

	use Str;

	class Validate extends \Validate {

		# Validate string using regex and length limitors

		private static function string(string $string, string $regex, int $min, int $max) {

			if (!preg_match($regex, $string)) return false;

			return ((Str::between($string, $min, $max)) ? $string : false);
		}

		# Validate auth code

		public static function authCode(string $value) {

			return (preg_match(REGEX_USER_AUTH_CODE, $value) ? $value : false);
		}

		# Validate user name

		public static function userName(string $value) {

			$min = CONFIG_USER_NAME_MIN_LENGTH; $max = CONFIG_USER_NAME_MAX_LENGTH;

			return self::string($value, REGEX_USER_NAME, $min, $max);
		}

		# Validate user password

		public static function userPassword(string $value) {

			$min = CONFIG_USER_PASSWORD_MIN_LENGTH; $max = CONFIG_USER_PASSWORD_MAX_LENGTH;

			return self::string($value, REGEX_USER_PASSWORD, $min, $max);
		}

		# Validate user email

		public static function userEmail(string $value) {

			return self::email($value);
		}

		# Validate file or directory name

		public static function fileName(string $value) {

			return (preg_match(REGEX_FILE_NAME, $value) ? $name : false);
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
