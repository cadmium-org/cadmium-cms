<?php

namespace Modules\Auth\Controller {

	use Modules\Auth, Modules\Entitizer, Utils\Security, Utils\Validate, Str;

	class Reset {

		# Invoker

		public function __invoke(array $post) {

			if (Auth::check()) return true;

			# Declare variables

			$name = ''; $captcha = '';

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Validate::userName($name))) return ['name', 'USER_ERROR_NAME_INVALID'];

			if (false === Security::checkCaptcha($captcha)) return ['captcha', 'USER_ERROR_CAPTCHA_INCORRECT'];

			# Create user object

			$user = Entitizer::get(TABLE_USERS);

			# Init user

			if (!$user->init($name, 'name')) return ['name', 'USER_ERROR_NAME_INCORRECT'];

			if (Auth::admin() && ($user->rank < RANK_ADMINISTRATOR)) return ['name', 'USER_ERROR_NAME_INCORRECT'];

			# Check access

			if (!Auth::admin() && ($user->rank === RANK_GUEST)) return 'USER_ERROR_ACCESS';

			# Create session

			$secret = Entitizer::get(TABLE_USERS_SECRETS, $user->id); $secret->remove();

			$code = Str::random(40); $ip = REQUEST_CLIENT_IP; $time = REQUEST_TIME;

			$data = ['id' => $user->id, 'code' => $code, 'ip' => $ip, 'time' => $time];

			if (!$secret->create($data)) return 'USER_ERROR_AUTH_RESET';

			# Send mail

			Auth\Utils\Mail::reset($user, $code);

			# ------------------------

			return true;
		}
	}
}
