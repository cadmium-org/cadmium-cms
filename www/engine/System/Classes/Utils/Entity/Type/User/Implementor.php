<?php

namespace System\Utils\Entity\Type\User {

	use String;

	class Implementor extends Definition {

        # Implement entity

        protected function implement() {

            $full_name = trim($this->data['first_name'] . ' ' . $this->data['last_name']);

            $this->data['full_name'] = String::validate($full_name);
        }

		# Validate name

		public static function validateName($name) {

			$name = String::validate($name);

			if (!preg_match(REGEX_USER_NAME, $name)) return false;

			$min = CONFIG_USER_NAME_MIN_LENGTH; $max = CONFIG_USER_NAME_MAX_LENGTH;

			# ------------------------

			return (preg_match(('/^(?=.{' . $min . ',' . $max . '}$).+$/'), $name) ? $name : false);
		}

		# Validate password

		public static function validatePassword($password) {

			$password = String::validate($password);

			if (!preg_match(REGEX_USER_PASSWORD, $password)) return false;

			$min = CONFIG_USER_PASSWORD_MIN_LENGTH; $max = CONFIG_USER_PASSWORD_MAX_LENGTH;

			# ------------------------

			return (preg_match(('/^(?=.{' . $min . ',' . $max . '}$).+$/'), $password) ? $password : false);
		}
	}
}
