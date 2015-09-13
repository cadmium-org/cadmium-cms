<?php

namespace System\Modules\Auth\Controller {

	use System\Modules\Auth, System\Modules\Entitizer, DB, Session, String;

	abstract class Login {

		# Errors

		const ERROR_AUTH_LOGIN              = 'USER_ERROR_AUTH_LOGIN';

		const ERROR_NAME_INVALID            = 'USER_ERROR_NAME_INVALID';
		const ERROR_NAME_INCORRECT          = 'USER_ERROR_NAME_INCORRECT';
		const ERROR_PASSWORD_INVALID        = 'USER_ERROR_PASSWORD_INVALID';
		const ERROR_PASSWORD_INCORRECT      = 'USER_ERROR_PASSWORD_INCORRECT';

		const ERROR_ACCESS                  = 'USER_ERROR_ACCESS';

		# Process post data

		public static function process($post) {

			if (0 !== Auth::user()->id) return true;

			# Declare variables

			$name = null; $password = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Auth\Validate::userName($name))) return self::ERROR_NAME_INVALID;

			if (false === ($password = Auth\Validate::userPassword($password))) return self::ERROR_PASSWORD_INVALID;

			# Select user from DB

			if (!Auth::user()->init($name, 'name')) return self::ERROR_NAME_INCORRECT;

			if (Auth::admin() && (Auth::user()->rank < RANK_ADMINISTRATOR)) return self::ERROR_NAME_INCORRECT;

			# Check password

			$password = String::encode(Auth::user()->auth_key, $password);

			if (0 !== strcmp(Auth::user()->password, $password)) return self::ERROR_PASSWORD_INCORRECT;

			# Check access

			if (!Auth::admin() && (Auth::user()->rank === RANK_GUEST)) return self::ERROR_ACCESS;

			# Create session

			$session = Entitizer::userSession(Auth::user()->id); $session->remove();

			$code = String::random(40); $ip = ENGINE_CLIENT_IP; $time = ENGINE_TIME;

			$data = array('id' => Auth::user()->id, 'code' => $code, 'ip' => $ip, 'time' => $time);

			if (!$session->create($data)) return self::ERROR_AUTH_LOGIN;

			# Set session variable

			Session::set(USER_SESSION_PARAM_CODE, $code);

			# ------------------------

			return true;
		}
	}
}
