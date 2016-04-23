<?php

namespace Modules\Auth\Controller {

	use Modules\Auth, Modules\Entitizer, Utils\Validate, Session, Str;

	class Login {

		# Invoker

		public function __invoke(array $post) {

			if (Auth::check()) return true;

			# Declare variables

			$name = ''; $password = '';

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Validate::userName($name))) return ['name', 'USER_ERROR_NAME_INVALID'];

			if (false === ($password = Validate::userPassword($password))) return ['password', 'USER_ERROR_PASSWORD_INVALID'];

			# Create user object

			$user = Entitizer::get(TABLE_USERS);

			# Init user

			if (!$user->init($name, 'name')) return ['name', 'USER_ERROR_NAME_INCORRECT'];

			if (Auth::admin() && ($user->rank < RANK_ADMINISTRATOR)) return ['name', 'USER_ERROR_NAME_INCORRECT'];

			# Check password

			$password = Str::encode($user->auth_key, $password);

			if (0 !== strcmp($user->password, $password)) return ['password', 'USER_ERROR_PASSWORD_INCORRECT'];

			# Check access

			if (!Auth::admin() && ($user->rank === RANK_GUEST)) return 'USER_ERROR_ACCESS';

			# Create session

			$session = Entitizer::get(TABLE_USERS_SESSIONS, $user->id); $session->remove();

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
