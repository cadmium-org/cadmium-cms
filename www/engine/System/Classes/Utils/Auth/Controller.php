<?php

namespace System\Utils\Auth {

	use System\Utils\Auth, DB, Session, String, Validate;

	abstract class Controller {

		# Errors

		const ERROR_AUTH_LOGIN                      = 'USER_ERROR_AUTH_LOGIN';
		const ERROR_AUTH_RESET                      = 'USER_ERROR_AUTH_RESET';
		const ERROR_AUTH_RECOVER                    = 'USER_ERROR_AUTH_RECOVER';
		const ERROR_AUTH_REGISTER                   = 'USER_ERROR_AUTH_REGISTER';

		const ERROR_NAME_INVALID                    = 'USER_ERROR_NAME_INVALID';
		const ERROR_NAME_INCORRECT                  = 'USER_ERROR_NAME_INCORRECT';
		const ERROR_NAME_DUPLICATE                  = 'USER_ERROR_NAME_DUPLICATE';
		const ERROR_EMAIL_INVALID                   = 'USER_ERROR_EMAIL_INVALID';
		const ERROR_EMAIL_DUPLICATE                 = 'USER_ERROR_EMAIL_DUPLICATE';
		const ERROR_PASSWORD_INVALID                = 'USER_ERROR_PASSWORD_INVALID';
		const ERROR_PASSWORD_INCORRECT              = 'USER_ERROR_PASSWORD_INCORRECT';
		const ERROR_PASSWORD_MISMATCH               = 'USER_ERROR_PASSWORD_MISMATCH';
		const ERROR_PASSWORD_NEW_INVALID            = 'USER_ERROR_PASSWORD_NEW_INVALID';
		const ERROR_CAPTCHA_INCORRECT               = 'USER_ERROR_CAPTCHA_INCORRECT';

		const ERROR_ACCESS                          = 'USER_ERROR_ACCESS';

		# Create new session

		public static function login($post) {

			if (0 !== Auth::user()->id) return true;

			# Declare variables

			$name = null; $password = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Auth::user()->validateName($name))) return self::ERROR_NAME_INVALID;

			if (false === ($password = Auth::user()->validatePassword($password))) return self::ERROR_PASSWORD_INVALID;

			# Select user from DB

			if (!Auth::user()->initByUnique('name', $name)) return self::ERROR_NAME_INCORRECT;

			if (Auth::admin() && (Auth::user()->rank < RANK_ADMINISTRATOR)) return self::ERROR_NAME_INCORRECT;

			# Check password

			$password = String::encode(Auth::user()->auth_key, $password);

			if (0 !== strcmp(Auth::user()->password, $password)) return self::ERROR_PASSWORD_INCORRECT;

			# Check access

			if (!Auth::admin() && (Auth::user()->rank === RANK_GUEST)) return self::ERROR_ACCESS;

			# Create session

			$id = Auth::user()->id; $code = String::random(40); $ip = ENGINE_CLIENT_IP; $time = ENGINE_TIME;

			DB::delete(TABLE_USERS_SESSIONS, array('id' => $id));

			$set = array('id' => $id, 'code' => $code, 'ip' => $ip, 'time' => $time);

			if (!(DB::insert(TABLE_USERS_SESSIONS, $set) && (DB::last()->status))) return self::ERROR_AUTH_LOGIN;

			Session::set(USER_SESSION_PARAM_CODE, $code);

			# ------------------------

			return true;
		}

		# Create new secret

		public static function reset($post) {

			if (0 !== Auth::user()->id) return true;

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

			# Create secret

			$id = Auth::user()->id; $code = String::random(40); $ip = ENGINE_CLIENT_IP; $time = ENGINE_TIME;

			DB::delete(TABLE_USERS_SECRETS, array('id' => $id));

			$set = array('id' => $id, 'code' => $code, 'ip' => $ip, 'time' => $time);

			if (!(DB::insert(TABLE_USERS_SECRETS, $set) && (DB::last()->status))) return self::ERROR_AUTH_RESET;

			# Send mail

			Mail::sendReset($code);

			# ------------------------

			return true;
		}

		# Recover password

		public static function recover($post) {

			if (0 === Auth::user()->id) return false;

			# Declare variables

			$password_new = null; $password_retype = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($password_new = Auth::user()->validatePassword($password_new))) return self::ERROR_PASSWORD_NEW_INVALID;

			if (0 !== strcmp($password_new, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password_new);

			# Update user

			$data = array();

			$data['auth_key']           = $auth_key;
			$data['password']           = $password;

			if (!Auth::user()->edit($data)) return self::ERROR_AUTH_RECOVER;

			# Remove secret

			DB::delete(TABLE_USERS_SECRETS, array('id' => Auth::user()->id));

			# ------------------------

			return true;
		}

		# Register new user

		public static function register($post) {

			if (0 !== Auth::user()->id) return true;

			# Declare variables

			$name = null; $password = null; $password_retype = null; $email = null; $captcha = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Auth::user()->validateName($name))) return self::ERROR_NAME_INVALID;

			if (false === ($password = Auth::user()->validatePassword($password))) return self::ERROR_PASSWORD_INVALID;

			if (false === ($email = Validate::email($email))) return self::ERROR_EMAIL_INVALID;

			if (0 !== strcmp($password, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;

			if (false === Auth::checkCaptcha($captcha)) return self::ERROR_CAPTCHA_INCORRECT;

			# Check name exists

			DB::select(TABLE_USERS, 'id', array('name' => $name), null, 1);

			if (!DB::last()->status) return self::ERROR_AUTH_REGISTER;

			if (DB::last()->rows === 1) return self::ERROR_NAME_DUPLICATE;

			# Check email exists

			DB::select(TABLE_USERS, 'id', array('email' => $email), null, 1);

			if (!DB::last()->status) return self::ERROR_AUTH_REGISTER;

			if (DB::last()->rows === 1) return self::ERROR_EMAIL_DUPLICATE;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password);

			# Determine rank

			$rank = (Auth::admin() ? RANK_ADMINISTRATOR : RANK_USER);

			# Create user

			$data = array();

			$data['name']               = $name;
			$data['email']              = $email;
			$data['auth_key']           = $auth_key;
			$data['password']           = $password;
			$data['rank']               = $rank;
			$data['time_registered']    = ENGINE_TIME;
			$data['time_logged']        = ENGINE_TIME;

			if (!Auth::user()->create($data)) return self::ERROR_AUTH_REGISTER;

			# Send mail

			Mail::sendRegister();

			# ------------------------

			return true;
		}

		# Delete session

		public static function logout() {

			if (0 === Auth::user()->id) return false;

			DB::delete(TABLE_USERS_SESSIONS, array('id' => Auth::user()->id));

			Session::delete(USER_SESSION_PARAM_CODE);

			# ------------------------

			return true;
		}
	}
}
