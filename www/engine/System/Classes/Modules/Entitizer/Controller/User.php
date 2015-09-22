<?php

namespace System\Modules\Entitizer\Controller {

	use System\Modules\Entitizer, DB, String, Validate;

	class User extends Entitizer\Utils\Controller {

        # Constructor

		public function __construct($id) {

			$this->entity = Entitizer::user($id);
		}

		# Process post data

		public function process($post) {

			# Declare variables

			$name = null; $email = null; $rank = null; $first_name = null; $last_name = null; $sex = null;

			$city = null; $country = null; $timezone = null; $password = null; $password_retype = null;

			# Extract post array

			extract($post);

			# Validate name & email

			if (false === ($name = Auth\Validate::userName($name))) return 'USER_ERROR_NAME_INVALID';

			if (false === ($email = Validate::email($email))) return 'USER_ERROR_EMAIL_INVALID';

			# Validate password

			if ((0 !== $this->entity->id) && ('' !== $password)) {

				if (false === ($password = Auth\Validate::userPassword($password))) return 'USER_ERROR_PASSWORD_INVALID';

				if (0 !== strcmp($password, $password_retype)) return 'USER_ERROR_PASSWORD_MISMATCH';
			}

			# Check name exists

			if (false === ($check_name = $this->entity->checkName($name))) return 'USER_ERROR_MODIFY';

			if ($check_name === 1) return 'USER_ERROR_NAME_DUPLICATE';

			# Check email exists

			if (false === ($check_email = $this->entity->checkEmail($email))) return 'USER_ERROR_MODIFY';

			if ($check_email === 1) return 'USER_ERROR_EMAIL_DUPLICATE';

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

			if ((0 !== $this->entity->id) && ('' !== $password)) {

				$data['auth_key']           = String::random(40);
				$data['password']           = String::encode($auth_key, $password);
			}

			if (0 === $this->entity->id) {

				$data['time_registered']    = REQUEST_TIME;
				$data['time_logged']        = REQUEST_TIME;
			}

			$modifier = ((0 === $this->entity->id) ? 'create' : 'edit');

			if (!call_user_func([$this->entity, $modifier], $data)) return 'USER_ERROR_MODIFY';

			# ------------------------

			return true;
		}
	}
}
