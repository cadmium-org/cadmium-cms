<?php

namespace Modules\Entitizer\Controller {

	use Modules\Auth, Modules\Entitizer, Utils\Validate, Str;

	class User {

		private $user = null;

		# Constructor

		public function __construct(Entitizer\Entity\User $user) {

			$this->user = $user;
		}

		# Invoker

		public function __invoke(array $post) {

			# Declare variables

			$name = ''; $email = ''; $rank = ''; $first_name = ''; $last_name = ''; $sex = '';

			$city = ''; $country = ''; $timezone = ''; $password = ''; $password_retype = '';

			# Extract post array

			extract($post);

			# Validate name & email

			if (false === ($name = Auth\Validate::userName($name))) return 'USER_ERROR_NAME_INVALID';

			if (false === ($email = Validate::email($email))) return 'USER_ERROR_EMAIL_INVALID';

			# Validate password

			if ((0 === $this->user->id) || ('' !== $password)) {

				if (false === ($password = Auth\Validate::userPassword($password))) return 'USER_ERROR_PASSWORD_INVALID';

				if (0 !== strcmp($password, $password_retype)) return 'USER_ERROR_PASSWORD_MISMATCH';
			}

			# Check name exists

			if (false === ($check_name = $this->user->check('name', $name))) return 'USER_ERROR_MODIFY';

			if ($check_name === 1) return 'USER_ERROR_NAME_DUPLICATE';

			# Check email exists

			if (false === ($check_email = $this->user->check('email', $email))) return 'USER_ERROR_MODIFY';

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
