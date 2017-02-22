<?php

/**
 * @package Cadmium\System\Modules\Profile
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Profile\Controller {

	use Modules\Auth, Utils\Validate, Str;

	class Password {

		/**
		 * Invoker
		 *
		 * @return true|string|array : true on success, otherwise an error code, or an array of type [$param_name, $error_code],
		 *         where $param_name is a name of param that has triggered the error,
		 *         and $error_code is a language phrase related to the error
		 */

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

			$password = Str::encode(Auth::get('auth_key'), $password);

			if (0 !== strcmp(Auth::get('password'), $password)) return ['password', 'USER_ERROR_PASSWORD_INCORRECT'];

			# Encode password

			$auth_key = Str::random(40); $password = Str::encode($auth_key, $password_new);

			# Update user

			$data = [];

			$data['auth_key']           = $auth_key;
			$data['password']           = $password;

			if (!Auth::getUser()->edit($data)) return 'USER_ERROR_EDIT_PASSWORD';

			# ------------------------

			return true;
		}
	}
}
