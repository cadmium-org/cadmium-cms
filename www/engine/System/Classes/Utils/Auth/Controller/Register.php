<?php

namespace System\Utils\Auth\Controller {

	use System\Utils\Auth, System\Utils\Validate, DB, String;

	abstract class Register {

		# Errors

		const ERROR_NAME_INVALID                    = 'USER_ERROR_NAME_INVALID';
		const ERROR_NAME_DUPLICATE                  = 'USER_ERROR_NAME_DUPLICATE';
		const ERROR_EMAIL_INVALID                   = 'USER_ERROR_EMAIL_INVALID';
		const ERROR_EMAIL_DUPLICATE                 = 'USER_ERROR_EMAIL_DUPLICATE';
		const ERROR_PASSWORD_INVALID                = 'USER_ERROR_PASSWORD_INVALID';
		const ERROR_PASSWORD_MISMATCH               = 'USER_ERROR_PASSWORD_MISMATCH';
		const ERROR_CAPTCHA_INCORRECT               = 'USER_ERROR_CAPTCHA_INCORRECT';

		# Process register operation

		public static function process($post) {

			# Declare variables

			$name = null; $password = null; $password_retype = null; $email = null; $captcha = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Validate::userName($name))) return self::ERROR_NAME_INVALID;

			if (false === ($password = Validate::userPassword($password))) return self::ERROR_PASSWORD_INVALID;

			if (false === ($email = Validate::email($email))) return self::ERROR_EMAIL_INVALID;

			if (0 !== strcmp($password, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;

			if (false === Auth::checkCaptcha($captcha)) return self::ERROR_CAPTCHA_INCORRECT;

			# Check name exists

			DB::select(TABLE_USERS, 'id', array('name' => $name), null, 1);

			if (!DB::last()->status) return false;

			if (DB::last()->rows === 1) return self::ERROR_NAME_DUPLICATE;

			# Check email exists

			DB::select(TABLE_USERS, 'id', array('email' => $email), null, 1);

			if (!DB::last()->status) return false;

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

			if (!Auth::user()->create($data)) return false;

			# ------------------------

			return true;
		}
	}
}
