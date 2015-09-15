<?php

namespace System\Modules\Auth\Controller {

	use System\Modules\Auth, System\Modules\Entitizer, DB, String;

	abstract class Recover {

		# Process post data

		public static function process($post) {

			if (0 === Auth::user()->id) return false;

			# Declare variables

			$password_new = null; $password_retype = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($password_new = Auth\Validate::userPassword($password_new))) return 'USER_ERROR_PASSWORD_NEW_INVALID';

			if (0 !== strcmp($password_new, $password_retype)) return 'USER_ERROR_PASSWORD_MISMATCH';

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password_new);

			# Update user

			$data = array('auth_key' => $auth_key, 'password' => $password);

			if (!Auth::user()->edit($data)) return 'USER_ERROR_AUTH_RECOVER';

			# Remove secret

			Entitizer::userSecret(Auth::user()->id)->remove();

			# ------------------------

			return true;
		}
	}
}
