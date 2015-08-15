<?php

namespace System\Utils\Auth {

	use System\Utils\Auth, DB, String, Validate;

	abstract class Edit {

		# Errors

		const ERROR_EDIT_PERSONAL                   = 'USER_ERROR_EDIT_PERSONAL';
		const ERROR_EDIT_PASSWORD                   = 'USER_ERROR_EDIT_PASSWORD';

		const ERROR_EMAIL_INVALID                   = 'USER_ERROR_EMAIL_INVALID';
		const ERROR_EMAIL_DUPLICATE                 = 'USER_ERROR_EMAIL_DUPLICATE';
		const ERROR_PASSWORD_INVALID                = 'USER_ERROR_PASSWORD_INVALID';
		const ERROR_PASSWORD_INCORRECT              = 'USER_ERROR_PASSWORD_INCORRECT';
		const ERROR_PASSWORD_MISMATCH               = 'USER_ERROR_PASSWORD_MISMATCH';
		const ERROR_PASSWORD_NEW_INVALID            = 'USER_ERROR_PASSWORD_NEW_INVALID';

		# Edit personal data

		public static function personal($post) {

			if (0 === Auth::user()->id) return false;

			# Declare variables

			$email = null; $first_name = null; $last_name = null; $sex = null;

			$city = null; $country = null; $timezone = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($email = Validate::email($email))) return self::ERROR_EMAIL_INVALID;

			# Check email exists

			$condition = ("email = '" . addslashes($email) . "' AND id != " . Auth::user()->id);

			DB::select(TABLE_USERS, 'id', $condition, null, 1);

			if (!DB::last()->status) return self::ERROR_EDIT_PERSONAL;

			if (DB::last()->rows === 1) return self::ERROR_EMAIL_DUPLICATE;

			# Update user

			$data = array();

			$data['email']              = $email;
			$data['first_name']         = $first_name;
			$data['last_name']          = $last_name;
			$data['sex']                = $sex;
			$data['city']               = $city;
			$data['country']            = $country;
			$data['timezone']           = $timezone;

			if (!Auth::user()->edit($data)) return self::ERROR_EDIT_PERSONAL;

			# ------------------------

			return true;
		}

		# Edit password data

		public static function password($post) {

			if (0 === Auth::user()->id) return false;

			# Declare variables

			$password = null; $password_new = null; $password_retype = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($password = Auth::user()->validatePassword($password))) return self::ERROR_PASSWORD_INVALID;

			if (false === ($password_new = Auth::user()->validatePassword($password_new))) return self::ERROR_PASSWORD_NEW_INVALID;

			if (0 !== strcmp($password_new, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;

			# Check password

			$password = String::encode(Auth::user()->auth_key, $password);

			if (0 !== strcmp(Auth::user()->password, $password)) return self::ERROR_PASSWORD_INCORRECT;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password_new);

			# Update user

			$data = array();

			$data['auth_key']           = $auth_key;
			$data['password']           = $password;

			if (!Auth::user()->edit($data)) return self::ERROR_EDIT_PASSWORD;

			# ------------------------

			return true;
		}
	}
}
