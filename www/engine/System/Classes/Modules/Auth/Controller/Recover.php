<?php

namespace System\Modules\Auth\Controller {

	use System\Modules\Auth as Module, System\Modules\Entitizer, DB, String;

	abstract class Recover {

		# Process post data

		public static function process(array $post) {

			if (!Module::check()) return false;

			# Declare variables

			$password_new = null; $password_retype = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($password_new = Module\Validate::userPassword($password_new))) return 'USER_ERROR_PASSWORD_NEW_INVALID';

			if (0 !== strcmp($password_new, $password_retype)) return 'USER_ERROR_PASSWORD_MISMATCH';

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password_new);

			# Update user

			$data = array('auth_key' => $auth_key, 'password' => $password);

			if (!Module::user()->edit($data)) return 'USER_ERROR_AUTH_RECOVER';

			# Remove secret

			Entitizer::userSecret(Module::user()->id)->remove();

			# ------------------------

			return true;
		}
	}
}
