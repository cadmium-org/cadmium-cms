<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Controller {

	use Modules\Auth, Modules\Entitizer, Utils\Validate, Session, Str;

	class Login {

		private $user = null;

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->user = Entitizer::get(TABLE_USERS);
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

			$name_email = ''; $password = '';

			# Extract post array

			extract($post);

			# Validate values

			if ((false === ($name = Validate::userName($name_email))) &&

				(false === ($email = Validate::userEmail($name_email)))) return ['name_email', 'USER_ERROR_NAME_INVALID'];

			if (false === ($password = Validate::userPassword($password))) return ['password', 'USER_ERROR_PASSWORD_INVALID'];

			# Init user

			$init_by = ((false !== $name) ? 'name' : 'email');

			if ((!$this->user->init($$init_by, $init_by)) || (Auth::isAdmin() && ($this->user->rank < RANK_ADMINISTRATOR))) {

				return ['name_email', ('USER_ERROR_' . strtoupper($init_by) .'_INCORRECT')];
			}

			# Check password

			$password = Str::encode($this->user->auth_key, $password);

			if (0 !== strcmp($this->user->password, $password)) return ['password', 'USER_ERROR_PASSWORD_INCORRECT'];

			# Check access

			if (!Auth::isAdmin() && ($this->user->rank === RANK_GUEST)) return 'USER_ERROR_ACCESS';

			# Create session

			$session = Entitizer::get(TABLE_USERS_SESSIONS, $this->user->id); $session->remove();

			$code = Str::random(40); $ip = REQUEST_CLIENT_IP; $time = REQUEST_TIME;

			$data = ['id' => $this->user->id, 'code' => $code, 'ip' => $ip, 'time' => $time];

			if (!$session->create($data)) return 'USER_ERROR_AUTH_LOGIN';

			# Set session variable

			Session::set('code', $code);

			# ------------------------

			return true;
		}
	}
}
