<?php

namespace System\Utils\Auth\Controller {

	use System\Utils\Auth, DB;

	abstract class Reset {

		# Errors

		const ERROR_NAME_INVALID                    = 'USER_ERROR_NAME_INVALID';
		const ERROR_NAME_INCORRECT                  = 'USER_ERROR_NAME_INCORRECT';
		const ERROR_CAPTCHA_INCORRECT               = 'USER_ERROR_CAPTCHA_INCORRECT';

		const ERROR_ACCESS                          = 'USER_ERROR_ACCESS';

		# Process reset operation

		public static function process($post) {

			# Declare variables

			$name = null; $captcha = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Auth::user()->validateName($name))) return self::ERROR_NAME_INVALID;

			if (false === Auth::checkCaptcha($captcha)) return self::ERROR_CAPTCHA_INCORRECT;

			# Select user from DB

			if (!Auth::user()->initByUnique('name', $name)) return self::ERROR_NAME_INCORRECT;

			if (Auth::admin() && (Auth::user()->rank < RANK_ADMINISTRATOR)) return self::ERROR_NAME_INCORRECT;

			# Check access

			if (!Auth::admin() && (Auth::user()->rank === RANK_GUEST)) return self::ERROR_ACCESS;

			# ------------------------

			return true;
		}
	}
}
