<?php

namespace System\Modules\Profile\Controller {

	use System\Modules\Auth, DB, String, Validate;

	abstract class Personal {

		# Process post data

		public static function process(array $post) {

			if (!Auth::check()) return false;

			# Declare variables

			$email = null; $first_name = null; $last_name = null; $sex = null;

			$city = null; $country = null; $timezone = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($email = Validate::email($email))) return 'USER_ERROR_EMAIL_INVALID';

			# Check email exists

			if (false === ($check_email = Auth::user()->checkEmail($email))) return 'USER_ERROR_EDIT_PERSONAL';

			if ($check_email === 1) return 'USER_ERROR_EMAIL_DUPLICATE';

			# Update user

			$data = array();

			$data['email']              = $email;
			$data['first_name']         = $first_name;
			$data['last_name']          = $last_name;
			$data['sex']                = $sex;
			$data['city']               = $city;
			$data['country']            = $country;
			$data['timezone']           = $timezone;

			if (!Auth::user()->edit($data)) return 'USER_ERROR_EDIT_PERSONAL';

			# ------------------------

			return true;
		}
	}
}
