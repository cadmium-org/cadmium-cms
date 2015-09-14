<?php

namespace System\Modules\Profile\Controller {

	use System\Modules\Auth, DB, String;

	abstract class Password {

		# Errors

		const ERROR_EDIT_PASSWORD                   = 'USER_ERROR_EDIT_PASSWORD';

		const ERROR_PASSWORD_INVALID                = 'USER_ERROR_PASSWORD_INVALID';
		const ERROR_PASSWORD_INCORRECT              = 'USER_ERROR_PASSWORD_INCORRECT';
		const ERROR_PASSWORD_MISMATCH               = 'USER_ERROR_PASSWORD_MISMATCH';
		const ERROR_PASSWORD_NEW_INVALID            = 'USER_ERROR_PASSWORD_NEW_INVALID';

		# Edit password data

		public static function process($post) {

			if (0 === Auth::user()->id) return false;

			# Declare variables

			$password = null; $password_new = null; $password_retype = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($password = Auth\Validate::userPassword($password))) return self::ERROR_PASSWORD_INVALID;

			if (false === ($password_new = Auth\Validate::userPassword($password_new))) return self::ERROR_PASSWORD_NEW_INVALID;

			if (0 !== strcmp($password_new, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;

			# Check password

			$password = String::encode(Auth::user()->auth_key, $password);

			if (0 !== strcmp(Auth::user()->password, $password)) return self::ERROR_PASSWORD_INCORRECT;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password_new);

			# Update user

			$data = array();

			$data['auth_key']           = $auth_key;
			$data['password']           = $password;

			if (!Auth::user()->edit($data)) return self::ERROR_EDIT_PASSWORD;

			# ------------------------

			return true;
		}
	}
}