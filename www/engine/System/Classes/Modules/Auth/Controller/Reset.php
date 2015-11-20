<?php

namespace System\Modules\Auth\Controller {

	use System\Modules\Auth, System\Modules\Entitizer, System\Utils\Security, Text;

	class Reset {

		# Invoker

		public function __invoke(array $post) {

			if (Auth::check()) return true;

			# Declare variables

			$name = ''; $captcha = '';

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Auth\Validate::userName($name))) return 'USER_ERROR_NAME_INVALID';

			if (false === Security::checkCaptcha($captcha)) return 'USER_ERROR_CAPTCHA_INCORRECT';

			# Create user object

			$user = Entitizer::user();

			# Init user

			if (!$user->init($name, 'name')) return 'USER_ERROR_NAME_INCORRECT';

			if (Auth::admin() && ($user->rank < RANK_ADMINISTRATOR)) return 'USER_ERROR_NAME_INCORRECT';

			# Check access

			if (!Auth::admin() && ($user->rank === RANK_GUEST)) return 'USER_ERROR_ACCESS';

			# Create session

			$secret = Entitizer::userSecret($user->id); $secret->remove();

			$code = Text::random(40); $ip = REQUEST_CLIENT_IP; $time = REQUEST_TIME;

			$data = ['id' => $user->id, 'code' => $code, 'ip' => $ip, 'time' => $time];

			if (!$secret->create($data)) return 'USER_ERROR_AUTH_RESET';

			# Send mail

			Auth\Utils\Mail::reset($user, $code);

			# ------------------------

			return true;
		}
	}
}
