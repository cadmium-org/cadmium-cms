<?php

namespace System\Utils\Entity\Type\User {

	use String;

	class Implementor extends Definition {

		# Validate param

		private static function validate($string, $regex, $min, $max) {

			if (!preg_match($regex, $string)) return false;

			return ((String::between($string, $min, $max)) ? $string : false);
		}

        # Implement entity

        protected function implement() {

            $this->data['full_name'] = trim($this->data['first_name'] . ' ' . $this->data['last_name']);
        }

		# Validate name

		public static function validateName($name) {

			$name = strval($name);

			$min = CONFIG_USER_NAME_MIN_LENGTH; $max = CONFIG_USER_NAME_MAX_LENGTH;

			return self::validate($name, REGEX_USER_NAME, $min, $max);

		}

		# Validate password

		public static function validatePassword($password) {

			$password = strval($password);

			$min = CONFIG_USER_PASSWORD_MIN_LENGTH; $max = CONFIG_USER_PASSWORD_MAX_LENGTH;

			return self::validate($password, REGEX_USER_PASSWORD, $min, $max);
		}
	}
}
