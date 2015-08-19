<?php

namespace System\Utils\Auth\Controller {

	use System\Utils\Auth, System\Utils\Validate, DB, String;

	abstract class Recover {

		# Errors

		const ERROR_PASSWORD_MISMATCH               = 'USER_ERROR_PASSWORD_MISMATCH';
		const ERROR_PASSWORD_NEW_INVALID            = 'USER_ERROR_PASSWORD_NEW_INVALID';

		# Process recover operation

		public static function process($post) {

			# Declare variables

			$password_new = null; $password_retype = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($password_new = Validate::userPassword($password_new))) return self::ERROR_PASSWORD_NEW_INVALID;

			if (0 !== strcmp($password_new, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password_new);

			# Update user

			$data = array('auth_key' => $auth_key, 'password' => $password);

			if (!Auth::user()->edit($data)) return false;

			# ------------------------

			return true;
		}
	}
}
