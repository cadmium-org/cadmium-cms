<?php

namespace System\Modules\Profile\Controller {

	use System\Modules\Auth, DB, String, Validate;

	abstract class Personal {

		# Errors

		const ERROR_EDIT_PERSONAL                   = 'USER_ERROR_EDIT_PERSONAL';

		const ERROR_EMAIL_INVALID                   = 'USER_ERROR_EMAIL_INVALID';
		const ERROR_EMAIL_DUPLICATE                 = 'USER_ERROR_EMAIL_DUPLICATE';

		# Edit personal data

		public static function process($post) {

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
	}
}
