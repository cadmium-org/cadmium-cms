<?php

namespace System\Utils {

	use Session, Str;

	class Security {

		# Generate and return captcha

		public static function generateCaptcha() {

			$captcha = Str::random(CONFIG_CAPTCHA_LENGTH, TEXT_POOl_LATIN_UPPER);

			Session::set('captcha', $captcha);

			# ------------------------

			return $captcha;
		}

		# Check captcha

		public static function checkCaptcha(string $captcha) {

			return (0 === strcasecmp(Session::get('captcha'), $captcha));
		}
	}
}
