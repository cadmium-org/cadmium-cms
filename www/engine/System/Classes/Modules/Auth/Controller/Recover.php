<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Controller {

	use Modules\Auth, Modules\Entitizer, Utils\Validate, Str;

	class Recover {

		private $user = null;

		/**
		 * Constructor
		 */

		public function __construct(Entitizer\Entity\User $user) {

			$this->user = $user;
		}

		/**
		 * Invoker
		 *
		 * @return true|string|array : true on success, otherwise an error code, or an array of type [$param_name, $error_code],
		 *         where $param_name is a name of param that has triggered the error,
		 *         and $error_code is a language phrase related to the error
		 */

		public function __invoke(array $post) {

			# Declare variables

			$password_new = ''; $password_retype = '';

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($password_new = Validate::userPassword($password_new)))

				return ['password_new', 'USER_ERROR_PASSWORD_NEW_INVALID'];

			if (0 !== strcmp($password_new, $password_retype))

				return ['password_retype', 'USER_ERROR_PASSWORD_MISMATCH'];

			# Encode password

			$auth_key = Str::random(40); $password = Str::encode($auth_key, $password_new);

			# Update user

			$data = ['auth_key' => $auth_key, 'password' => $password];

			if (!$this->user->edit($data)) return 'USER_ERROR_AUTH_RECOVER';

			# Remove secret

			Entitizer::get(TABLE_USERS_SECRETS, $this->user->id)->remove();

			# ------------------------

			return true;
		}
	}
}
