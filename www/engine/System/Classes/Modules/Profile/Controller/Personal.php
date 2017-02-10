<?php

/**
 * @package Cadmium\System\Modules\Profile
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Profile\Controller {

	use Modules\Auth, Utils\Validate;

	class Personal {

		/**
		 * Invoker
		 *
		 * @return true|string|array : true on success, otherwise an error code, or an array of type [$param_name, $error_code],
		 *         where $param_name is a name of param that has triggered the error,
		 *         and $error_code is a language phrase related to the error
		 */

		public function __invoke(array $post) {

			# Declare variables

			$email = ''; $first_name = ''; $last_name = ''; $sex = ''; $city = ''; $country = ''; $timezone = '';

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($email = Validate::userEmail($email))) return ['email', 'USER_ERROR_EMAIL_INVALID'];

			# Check email exists

			if (false === ($check_email = Auth::getUser()->check($email, 'email'))) return 'USER_ERROR_EDIT_PERSONAL';

			if ($check_email === 1) return ['email', 'USER_ERROR_EMAIL_DUPLICATE'];

			# Update user

			$data = [];

			$data['email']              = $email;
			$data['first_name']         = $first_name;
			$data['last_name']          = $last_name;
			$data['sex']                = $sex;
			$data['city']               = $city;
			$data['country']            = $country;
			$data['timezone']           = $timezone;

			if (!Auth::getUser()->edit($data)) return 'USER_ERROR_EDIT_PERSONAL';

			# ------------------------

			return true;
		}
	}
}
