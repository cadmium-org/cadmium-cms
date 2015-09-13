<?php

namespace System\Modules\Auth\Controller {

	use System\Modules\Auth, System\Modules\Entitizer, DB;

	abstract class Reset {

		# Errors

		const ERROR_AUTH_RESET              = 'USER_ERROR_AUTH_RESET';

		const ERROR_NAME_INVALID            = 'USER_ERROR_NAME_INVALID';
		const ERROR_NAME_INCORRECT          = 'USER_ERROR_NAME_INCORRECT';
		const ERROR_CAPTCHA_INCORRECT       = 'USER_ERROR_CAPTCHA_INCORRECT';

		const ERROR_ACCESS                  = 'USER_ERROR_ACCESS';

		# Process post data

		public static function process($post) {

			if (0 !== Auth::user()->id) return true;

			# Declare variables

			$name = null; $captcha = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Auth\Validate::userName($name))) return self::ERROR_NAME_INVALID;

			if (false === Auth::checkCaptcha($captcha)) return self::ERROR_CAPTCHA_INCORRECT;

			# Select user from DB

			if (!Auth::user()->init($name, 'name')) return self::ERROR_NAME_INCORRECT;

			if (Auth::admin() && (Auth::user()->rank < RANK_ADMINISTRATOR)) return self::ERROR_NAME_INCORRECT;

			# Check access

			if (!Auth::admin() && (Auth::user()->rank === RANK_GUEST)) return self::ERROR_ACCESS;

			# Create session

			$secret = Entitizer::userSecret(Auth::user()->id); $secret->remove();

			$code = String::random(40); $ip = ENGINE_CLIENT_IP; $time = ENGINE_TIME;

			$data = array('id' => Auth::user()->id, 'code' => $code, 'ip' => $ip, 'time' => $time);

			if (!$secret->create($data)) return self::ERROR_AUTH_RESET;

			# Send mail

			Auth\Utils\Mail::reset($code);

			# ------------------------

			return true;
		}
	}
}
