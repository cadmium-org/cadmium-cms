<?php

namespace System\Modules\Auth\Controller {

	use System\Modules\Auth, System\Modules\Security, System\Modules\Entitizer, DB;

	abstract class Reset {

		# Process post data

		public static function process($post) {

			if (0 !== Auth::user()->id) return true;

			# Declare variables

			$name = null; $captcha = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Auth\Validate::userName($name))) return 'USER_ERROR_NAME_INVALID';

			if (false === Security::checkCaptcha($captcha)) return 'USER_ERROR_CAPTCHA_INCORRECT';

			# Create user object

			$user = Entitizer::user();

			if (!$user->init($name, 'name')) return 'USER_ERROR_NAME_INCORRECT';

			if (Auth::admin() && ($user->rank < RANK_ADMINISTRATOR)) return 'USER_ERROR_NAME_INCORRECT';

			# Check access

			if (!Auth::admin() && ($user->rank === RANK_GUEST)) return 'USER_ERROR_ACCESS';

			# Create session

			$secret = Entitizer::userSecret($user->id); $secret->remove();

			$code = String::random(40); $ip = REQUEST_CLIENT_IP; $time = REQUEST_TIME;

			$data = array('id' => $user->id, 'code' => $code, 'ip' => $ip, 'time' => $time);

			if (!$secret->create($data)) return 'USER_ERROR_AUTH_RESET';

			# Send mail

			Auth\Utils\Mail::reset($code);

			# ------------------------

			return true;
		}
	}
}
