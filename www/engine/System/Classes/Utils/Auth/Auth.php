<?php

namespace System\Utils {

	use System\Utils\Entity, DB, Request, Session, String;

	abstract class Auth {

		private static $user = null, $admin = false, $init = false;

		# Validate auth code

		private static function validateCode($code) {

			$code = strval($code);

			return (preg_match(REGEX_USER_AUTH_CODE, $code) ? $code : false);
		}

		# Autoloader

		public static function __autoload() {

			self::$user = Entity\Factory::user();
		}

		# Authorize with session code

		public static function session($admin = false) {

			if (0 !== self::$user->id) return true;

			self::$admin = boolval($admin);

			if (false === ($code = self::validateCode(Session::get(USER_SESSION_PARAM_CODE)))) return false;

			# Select user from DB

			$rank = (self::$admin ? RANK_ADMINISTRATOR : RANK_USER);

			$ip = addslashes(ENGINE_CLIENT_IP); $time = (ENGINE_TIME - CONFIG_USER_SESSION_LIFETIME);

			$query = ("SELECT usr.id FROM " . TABLE_USERS_SESSIONS . " ses ") .

					 ("INNER JOIN " . TABLE_USERS . " usr ON usr.id = ses.id AND usr.rank >= " . $rank . " ") .

					 ("WHERE ses.code = '" . $code . "' AND ses.ip = '" . $ip . "' AND ses.time > " . $time . " LIMIT 1");

			if (!(DB::send($query) && (DB::last()->rows === 1))) return false;

			if (!self::$user->initById(DB::last()->row()['id'])) return false;

			# Update session

			DB::update(TABLE_USERS_SESSIONS, array('time' => ENGINE_TIME), array('id' => self::$user->id));

			# Update activity

			DB::update(TABLE_USERS, array('time_logged' => ENGINE_TIME), array('id' => self::$user->id));

			# ------------------------

			return (self::$init = true);
		}

		# Authorize with secret code

		public static function secret($admin = false) {

			if (0 !== self::$user->id) return true;

			self::$admin = boolval($admin);

			if (false === ($code = self::validateCode(Request::get(USER_SECRET_PARAM_CODE)))) return false;

			# Select user from DB

			$rank = (self::$admin ? RANK_ADMINISTRATOR : RANK_USER);

			$ip = addslashes(ENGINE_CLIENT_IP); $time = (ENGINE_TIME - CONFIG_USER_SECRET_LIFETIME);

			$query = ("SELECT usr.id FROM " . TABLE_USERS_SECRETS . " sec ") .

					 ("INNER JOIN " . TABLE_USERS . " usr ON usr.id = sec.id AND usr.rank >= " . $rank . " ") .

					 ("WHERE sec.code = '" . $code . "' AND sec.ip = '" . $ip . "' AND sec.time > " . $time . " LIMIT 1");

			if (!(DB::send($query) && (DB::last()->rows === 1))) return false;

			if (!self::$user->initById(DB::last()->row()['id'])) return false;

			# ------------------------

			return $code;
		}

		# Generate and return captcha

		public static function generateCaptcha() {

			$captcha = String::random(CONFIG_CAPTCHA_LENGTH, STRING_POOL_LATIN_UPPER);

			Session::set(USER_SESSION_PARAM_CAPTCHA, $captcha);

			# ------------------------

			return $captcha;
		}

		# Check captcha

		public static function checkCaptcha($captcha) {

			$captcha = strval($captcha);

			return (0 === strcasecmp(Session::get(USER_SESSION_PARAM_CAPTCHA), $captcha));
		}

		# Return user object

		public static function user() {

			return self::$user;
		}

		# Check if mode is set to admin

		public static function admin() {

			return self::$admin;
		}

		# Check if authorized

		public static function check() {

			return self::$init;
		}
	}
}
