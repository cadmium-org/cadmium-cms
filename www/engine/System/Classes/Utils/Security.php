<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils {

	use Session, Str;

	class Security {

		/**
		 * Generate and return captcha
		 */

		public static function generateCaptcha() : string {

			$captcha = Str::random(CONFIG_CAPTCHA_LENGTH, STR_POOL_LATIN_UPPER);

			Session::set('captcha', $captcha);

			# ------------------------

			return $captcha;
		}

		/**
		 * Check if a given captcha is valid
		 */

		public static function checkCaptcha(string $captcha) : bool {

			return (0 === strcasecmp((Session::get('captcha') ?? ''), $captcha));
		}
	}
}
