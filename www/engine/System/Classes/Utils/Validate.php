<?php

namespace System\Utils {

	use String, Validate as FrameworkValidate;

	abstract class Validate extends FrameworkValidate {

		# Validate param

		private static function validate($string, $regex, $min, $max) {

			if (!preg_match($regex, $string)) return false;

			return ((String::between($string, $min, $max)) ? $string : false);
		}

		# Validate user name

		public static function userName($name) {

			$name = strval($name);

			$min = CONFIG_USER_NAME_MIN_LENGTH; $max = CONFIG_USER_NAME_MAX_LENGTH;

			return self::validate($name, REGEX_USER_NAME, $min, $max);
		}

		# Validate user password

		public static function userPassword($password) {

			$password = strval($password);

			$min = CONFIG_USER_PASSWORD_MIN_LENGTH; $max = CONFIG_USER_PASSWORD_MAX_LENGTH;

			return self::validate($password, REGEX_USER_PASSWORD, $min, $max);
		}
	}
}
