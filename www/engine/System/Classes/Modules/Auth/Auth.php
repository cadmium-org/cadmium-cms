<?php

namespace System\Modules {

	use DB, Request, Session, String;

	abstract class Auth {

		private static $admin = false, $user = null;

		# Authorize with session code

		public static function init($section) {

			self::$admin = ($section === SECTION_ADMIN); self::$user = Entitizer::user();

			# Check session code

			if (false === ($code = Auth\Validate::code(Session::get('code')))) return false;

			# Load session

			$session = Entitizer::userSession();

			if (!$session->init($code, 'code') || ($session->ip !== REQUEST_CLIENT_IP)) return false;

			if ($session->time < (REQUEST_TIME - CONFIG_USER_SESSION_LIFETIME)) return false;

			# Load user

			$user = Entitizer::user($session->id);

			if ((0 === $user->id) || ($user->rank < (self::$admin ? RANK_ADMINISTRATOR : RANK_USER))) return false;

			self::$user = $user;

			# Update session

			$session->edit(['time' => REQUEST_TIME]);

			# Update activity

			$user->edit(['time_logged' => REQUEST_TIME]);

			# ------------------------

			return true;
		}

		# Authorize with secret code

		public static function secret() {

			if (null === self::$user) return false;

			if (0 !== self::$user->id) return true;

			# Check secret code

			if (false === ($code = Auth\Validate::code(Request::get('code')))) return false;

			# Load secret

			$secret = Entitizer::userSession();

			if (!$secret->init($code, 'code') || ($secret->ip !== REQUEST_CLIENT_IP)) return false;

			if ($secret->time < (REQUEST_TIME - CONFIG_USER_SECRET_LIFETIME)) return false;

			# Load user

			$user = Entitizer::user($secret->id);

			if ((0 === $user->id) || ($user->rank < (self::$admin ? RANK_ADMINISTRATOR : RANK_USER))) return false;

			self::$user = $user;

			# ------------------------

			return $code;
		}

		# Delete session

		public static function logout() {

			if ((null === self::$user) || (0 === self::$user->id)) return false;

			# Remove session

			Entitizer::userSession(self::$user->id)->remove();

			# Remove session variable

			Session::delete('code');

			# ------------------------

			return true;
		}

		# Check if initial registration required

        public static function initial() {

			$user = Entitizer::user(1);

			return (!$user->error() && (0 === $user->id));
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
