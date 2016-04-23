<?php

namespace Modules\Profile\Controller {

	use Modules\Auth, Utils\Validate, Str;

	class Password {

		# Invoker

		public function __invoke(array $post) {

			# Declare variables

			$password = ''; $password_new = ''; $password_retype = '';

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($password = Validate::userPassword($password)))

				return ['password', 'USER_ERROR_PASSWORD_INVALID'];

			if (false === ($password_new = Validate::userPassword($password_new)))

				return ['password_new', 'USER_ERROR_PASSWORD_NEW_INVALID'];

			if (0 !== strcmp($password_new, $password_retype))

				return ['password_retype', 'USER_ERROR_PASSWORD_MISMATCH'];

			# Check password

			$password = Str::encode(Auth::user()->auth_key, $password);

			if (0 !== strcmp(Auth::user()->password, $password)) return ['password', 'USER_ERROR_PASSWORD_INCORRECT'];

			# Encode password

			$auth_key = Str::random(40); $password = Str::encode($auth_key, $password_new);

			# Update user

			$data = [];

			$data['auth_key']           = $auth_key;
			$data['password']           = $password;

			if (!Auth::user()->edit($data)) return 'USER_ERROR_EDIT_PASSWORD';

			# ------------------------

			return true;
		}
	}
}
