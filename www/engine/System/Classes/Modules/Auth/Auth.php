<?php

namespace System\Modules {

	use DB, Request, Session, String;

	abstract class Auth {

		private static $admin = false, $user = null;

		# Authorize with session code

		public static function init($section) {

			self::$admin = ($section === SECTION_ADMIN); self::$user = Entitizer::user();

			if (false === ($code = Auth\Validate::code(Session::get(USER_SESSION_PARAM_CODE)))) return false;

			# Select user from DB

			$rank = (self::$admin ? RANK_ADMINISTRATOR : RANK_USER);

			$ip = addslashes(REQUEST_CLIENT_IP); $time = (REQUEST_TIME - CONFIG_USER_SESSION_LIFETIME);

			$query = ("SELECT usr.id FROM " . TABLE_USERS_SESSIONS . " ses ") .

					 ("INNER JOIN " . TABLE_USERS . " usr ON usr.id = ses.id AND usr.rank >= " . $rank . " ") .

					 ("WHERE ses.code = '" . $code . "' AND ses.ip = '" . $ip . "' AND ses.time > " . $time . " LIMIT 1");

			if (!(DB::send($query) && (DB::last()->rows === 1))) return false;

			if (!self::$user->init(DB::last()->row()['id'])) return false;

			# Update session

			Entitizer::userSession(self::$user->id)->edit(array('time' => REQUEST_TIME));

			# Update activity

			self::$user->edit(array('time_logged' => REQUEST_TIME));

			# ------------------------

			return true;
		}

		# Authorize with secret code

		public static function secret() {

			if (null === self::$user) return false;

			if (0 !== self::$user->id) return true;

			if (false === ($code = Auth\Validate::code(Request::get(USER_SECRET_PARAM_CODE)))) return false;

			# Select user from DB

			$rank = (self::$admin ? RANK_ADMINISTRATOR : RANK_USER);

			$ip = addslashes(REQUEST_CLIENT_IP); $time = (REQUEST_TIME - CONFIG_USER_SECRET_LIFETIME);

			$query = ("SELECT usr.id FROM " . TABLE_USERS_SECRETS . " sec ") .

					 ("INNER JOIN " . TABLE_USERS . " usr ON usr.id = sec.id AND usr.rank >= " . $rank . " ") .

					 ("WHERE sec.code = '" . $code . "' AND sec.ip = '" . $ip . "' AND sec.time > " . $time . " LIMIT 1");

			if (!(DB::send($query) && (DB::last()->rows === 1))) return false;

			if (!self::$user->init(DB::last()->row()['id'])) return false;

			# ------------------------

			return $code;
		}

		# Delete session

		public static function logout() {

			if ((null === self::$user) || (0 === Auth::user()->id)) return false;

			# Remove session

			Entitizer::userSession(self::$user->id)->remove();

			# Remove session variable

			Session::delete(USER_SESSION_PARAM_CODE);

			# ------------------------

			return true;
		}

		# Check if initial registration required

        public static function initial() {

			DB::select(TABLE_USERS, 'id', array('id' => 1), null, 1);

			if (!(DB::last() && DB::last()->status)) return false;

			# ------------------------

			return (DB::last()->rows === 0);
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

		# Check if authorized

		public static function check() {

			return ((null !== self::$user) && (0 !== self::$user->id));
		}

		# Check if mode is set to admin

		public static function admin() {

			return self::$admin;
		}

		# Return user object

		public static function user() {

			return self::$user;
		}
	}
}
