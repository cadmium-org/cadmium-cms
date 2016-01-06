<?php

namespace Modules\Auth\Controller {

	use Modules\Auth, Modules\Entitizer, Str;

	class Recover {

		# Invoker

		public function __invoke(array $post) {

			if (!Auth::check()) return false;

			# Declare variables

			$password_new = ''; $password_retype = '';

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($password_new = Auth\Validate::userPassword($password_new))) return 'USER_ERROR_PASSWORD_NEW_INVALID';

			if (0 !== strcmp($password_new, $password_retype)) return 'USER_ERROR_PASSWORD_MISMATCH';

			# Encode password

			$auth_key = Str::random(40); $password = Str::encode($auth_key, $password_new);

			# Update user

			$data = ['auth_key' => $auth_key, 'password' => $password];

			if (!Auth::user()->edit($data)) return 'USER_ERROR_AUTH_RECOVER';

			# Remove secret

			Entitizer::get(ENTITY_TYPE_USER_SECRET, Auth::user()->id)->remove();

			# ------------------------

			return true;
		}
	}
}
