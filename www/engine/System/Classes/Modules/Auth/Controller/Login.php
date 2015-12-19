<?php

namespace System\Modules\Auth\Controller {

	use System\Modules\Auth, System\Modules\Entitizer, Session, Str;

	class Login {

		# Invoker

		public function __invoke(array $post) {

			if (Auth::check()) return true;

			# Declare variables

			$name = ''; $password = '';

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Auth\Validate::userName($name))) return 'USER_ERROR_NAME_INVALID';

			if (false === ($password = Auth\Validate::userPassword($password))) return 'USER_ERROR_PASSWORD_INVALID';

			# Create user object

			$user = Entitizer::user();

			# Init user

			if (!$user->init($name, 'name')) return 'USER_ERROR_NAME_INCORRECT';

			if (Auth::admin() && ($user->rank < RANK_ADMINISTRATOR)) return 'USER_ERROR_NAME_INCORRECT';

			# Check password

			$password = Str::encode($user->auth_key, $password);

			if (0 !== strcmp($user->password, $password)) return 'USER_ERROR_PASSWORD_INCORRECT';

			# Check access

			if (!Auth::admin() && ($user->rank === RANK_GUEST)) return 'USER_ERROR_ACCESS';

			# Create session

			$session = Entitizer::userSession($user->id); $session->remove();

			$code = Str::random(40); $ip = REQUEST_CLIENT_IP; $time = REQUEST_TIME;

			$data = ['id' => $user->id, 'code' => $code, 'ip' => $ip, 'time' => $time];

			if (!$session->create($data)) return 'USER_ERROR_AUTH_LOGIN';

			# Set session variable

			Session::set('code', $code);

			# ------------------------

			return true;
		}
	}
}
