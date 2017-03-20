<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Controller {

	use Modules\Entitizer, Utils\Validate, Str;

	class User {

		private $user = null;

		/**
		 * Constructor
		 */

		public function __construct(Entitizer\Entity\User $user) {

			$this->user = $user;
		}

		/**
		 * Invoker
		 *
		 * @return true|string|array : true on success, otherwise an error code, or an array of type [$param_name, $error_code],
		 *         where $param_name is a name of param that has triggered the error,
		 *         and $error_code is a language phrase related to the error
		 */

		public function __invoke(array $post) {

			# Declare variables

			$name = ''; $email = ''; $rank = ''; $first_name = ''; $last_name = ''; $sex = '';

			$city = ''; $country = ''; $timezone = ''; $password = ''; $password_retype = '';

			# Extract post array

			extract($post);

			# Validate name & email

			if (false === ($name = Validate::userName($name))) return ['name', 'USER_ERROR_NAME_INVALID'];

			if (false === ($email = Validate::userEmail($email))) return ['email', 'USER_ERROR_EMAIL_INVALID'];

			# Validate password

			if ((0 === $this->user->id) || ('' !== $password)) {

				if (false === ($password = Validate::userPassword($password))) return ['password', 'USER_ERROR_PASSWORD_INVALID'];

				if (0 !== strcmp($password, $password_retype)) return ['password_retype', 'USER_ERROR_PASSWORD_MISMATCH'];
			}

			# Check name exists

			if (false === ($check_name = $this->user->check($name, 'name'))) return 'USER_ERROR_MODIFY';

			if ($check_name === 1) return ['name', 'USER_ERROR_NAME_DUPLICATE'];

			# Check email exists

			if (false === ($check_email = $this->user->check($email, 'email'))) return 'USER_ERROR_MODIFY';

			if ($check_email === 1) return ['email', 'USER_ERROR_EMAIL_DUPLICATE'];

			# Modify user

			$data = [];

			$data['name']               = $name;
			$data['email']              = $email;
			$data['rank']               = $rank;
			$data['first_name']         = $first_name;
			$data['last_name']          = $last_name;
			$data['sex']                = $sex;
			$data['city']               = $city;
			$data['country']            = $country;
			$data['timezone']           = $timezone;

			if ((0 === $this->user->id) || ('' !== $password)) {

				$data['auth_key']           = ($auth_key = Str::random(40));
				$data['password']           = Str::encode($auth_key, $password);
			}

			if (0 === $this->user->id) {

				$data['time_registered']    = REQUEST_TIME;
				$data['time_logged']        = REQUEST_TIME;
			}

			$modifier = ((0 === $this->user->id) ? 'create' : 'edit');

			if (!$this->user->$modifier($data)) return 'USER_ERROR_MODIFY';

			# ------------------------

			return true;
		}
	}
}
