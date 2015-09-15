<?php

namespace System\Utils {

	use Session, String;

	class Security {

		# Generate and return captcha

		public static function generateCaptcha() {

			$captcha = String::random(CONFIG_CAPTCHA_LENGTH, STRING_POOL_LATIN_UPPER);

			Session::set('captcha', $captcha);

			# ------------------------

			return $captcha;
		}

		# Check captcha

		public static function checkCaptcha($captcha) {

			$captcha = strval($captcha);

			return (0 === strcasecmp(Session::get('captcha'), $captcha));
		}
	}
}
