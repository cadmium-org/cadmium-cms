<?php

namespace System\Modules {

	use DB, Request, Session, Text;

	abstract class Auth {

		private static $admin = false, $user = null;

		# Get auth

		private static function getAuth($code, $type, $lifetime) {

			$auth = Entitizer::create($type);

			if (!$auth->init($code, 'code') || ($auth->ip !== REQUEST_CLIENT_IP)) return false;

			if ($auth->time < (REQUEST_TIME - $lifetime)) return false;

			# ------------------------

			return $auth;
		}

		# Get user

		private static function getUser($id) {

			$user = Entitizer::user($id);

			if ((0 === $user->id) || ($user->rank < (self::$admin ? RANK_ADMINISTRATOR : RANK_USER))) return false;

			# ------------------------

			return (self::$user = $user);
		}

		# Authorize with session code

		public static function init($section) {

			self::$admin = ($section === SECTION_ADMIN); self::$user = Entitizer::user();

			# Check session code

			if (false === ($code = Auth\Validate::code(Session::get('code')))) return false;

			# Get auth

			$type = ENTITY_TYPE_USER_SESSION; $lifetime = CONFIG_USER_SESSION_LIFETIME;

			if (false === ($session = self::getAuth($code, $type, $lifetime))) return false;

			# Get user

			if (false === ($user = self::getUser($session->id))) return false;

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

			# Get auth

			$type = ENTITY_TYPE_USER_SECRET; $lifetime = CONFIG_USER_SECRET_LIFETIME;

			if (false === ($secret = self::getAuth($code, $type, $lifetime))) return false;

			# Get user

			if (false === ($user = self::getUser($secret->id))) return false;

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

			return (0 === Informer::countUsers(true));
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
