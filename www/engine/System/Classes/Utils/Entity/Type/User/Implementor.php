<?php

namespace System\Utils\Entity\Type\User {

	class Implementor extends Definition {

        # Implement entity

        protected function implement() {

            $this->data['full_name'] = trim($this->data['first_name'] . ' ' . $this->data['last_name']);
        }

		# Validate name

		public static function validateName($name) {

			$name = strval($name);

			if (!preg_match(REGEX_USER_NAME, $name)) return false;

			$min = CONFIG_USER_NAME_MIN_LENGTH; $max = CONFIG_USER_NAME_MAX_LENGTH;

			# ------------------------

			return (preg_match(('/^(?=.{' . $min . ',' . $max . '}$).+$/'), $name) ? $name : false);
		}

		# Validate password

		public static function validatePassword($password) {

			$password = strval($password);

			if (!preg_match(REGEX_USER_PASSWORD, $password)) return false;

			$min = CONFIG_USER_PASSWORD_MIN_LENGTH; $max = CONFIG_USER_PASSWORD_MAX_LENGTH;

			# ------------------------

			return (preg_match(('/^(?=.{' . $min . ',' . $max . '}$).+$/'), $password) ? $password : false);
		}
	}
}
