<?php

namespace System\Modules\Auth\Controller {

	use System\Modules\Auth as Module, System\Modules\Entitizer, DB, Session, String;

	abstract class Login {

		# Process post data

		public static function process(array $post) {

			if (Module::check()) return true;

			# Declare variables

			$name = null; $password = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Module\Validate::userName($name))) return 'USER_ERROR_NAME_INVALID';

			if (false === ($password = Module\Validate::userPassword($password))) return 'USER_ERROR_PASSWORD_INVALID';

			# Create user object

			$user = Entitizer::user();

			# Init user

			if (!$user->init($name, 'name')) return 'USER_ERROR_NAME_INCORRECT';

			if (Module::admin() && ($user->rank < RANK_ADMINISTRATOR)) return 'USER_ERROR_NAME_INCORRECT';

			# Check password

			$password = String::encode($user->auth_key, $password);

			if (0 !== strcmp($user->password, $password)) return 'USER_ERROR_PASSWORD_INCORRECT';

			# Check access

			if (!Module::admin() && ($user->rank === RANK_GUEST)) return 'USER_ERROR_ACCESS';

			# Create session

			$session = Entitizer::userSession($user->id); $session->remove();

			$code = String::random(40); $ip = REQUEST_CLIENT_IP; $time = REQUEST_TIME;

			$data = array('id' => $user->id, 'code' => $code, 'ip' => $ip, 'time' => $time);

			if (!$session->create($data)) return 'USER_ERROR_AUTH_LOGIN';

			# Set session variable

			Session::set('code', $code);

			# ------------------------

			return true;
		}
	}
}
