<?php

namespace Modules\Profile\Controller {

	use Modules\Auth, Validate;

	class Personal {

		# Invoker

		public function __invoke(array $post) {

			# Declare variables

			$email = ''; $first_name = ''; $last_name = ''; $sex = ''; $city = ''; $country = ''; $timezone = '';

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($email = Validate::email($email))) return 'USER_ERROR_EMAIL_INVALID';

			# Check email exists

			if (false === ($check_email = Auth::user()->check('email', $email))) return 'USER_ERROR_EDIT_PERSONAL';

			if ($check_email === 1) return 'USER_ERROR_EMAIL_DUPLICATE';

			# Update user

			$data = [];

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
