<?php

namespace System\Modules\Entitizer\Controller {

	use System\Modules\Entitizer, DB, String, Validate;

	class User extends Entitizer\Utils\Controller {

        # Constructor

		public function __construct($id) {

			$this->entity = Entitizer::user($id);
		}

		# Create user

		public function create($post) {

			if (0 !== $this->entity->id) return true;

			# Declare variables

			$name = null; $email = null; $rank = null; $first_name = null; $last_name = null; $sex = null;

			$city = null; $country = null; $timezone = null; $password = null; $password_retype = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Auth\Validate::userName($name))) return 'USER_ERROR_NAME_INVALID';

			if (false === ($email = Validate::email($email))) return 'USER_ERROR_EMAIL_INVALID';

			if (false === ($password = Auth\Validate::userPassword($password))) return 'USER_ERROR_PASSWORD_INVALID';

			if (0 !== strcmp($password, $password_retype)) return 'USER_ERROR_PASSWORD_MISMATCH';

			# Check name exists

			DB::select(TABLE_USERS, 'id', ['name' => $name], null, 1);

			if (!DB::last()->status) return 'USER_ERROR_CREATE';

			if (DB::last()->rows === 1) return 'USER_ERROR_NAME_DUPLICATE';

			# Check email exists

			DB::select(TABLE_USERS, 'id', ['email' => $email], null, 1);

			if (!DB::last()->status) return 'USER_ERROR_CREATE';

			if (DB::last()->rows === 1) return 'USER_ERROR_EMAIL_DUPLICATE';

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password);

			# Create user

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
            $data['auth_key']           = $auth_key;
			$data['password']           = $password;
			$data['time_registered']    = REQUEST_TIME;
			$data['time_logged']        = REQUEST_TIME;

            if (!$this->entity->create($data)) return 'USER_ERROR_CREATE';

			# ------------------------

			return true;
		}

		# Edit user

		public function edit($post) {

			if (0 === $this->entity->id) return false;

			# Declare variables

			$name = null; $email = null; $rank = null; $first_name = null; $last_name = null; $sex = null;

			$city = null; $country = null; $timezone = null; $password = null; $password_retype = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Auth\Validate::userName($name))) return 'USER_ERROR_NAME_INVALID';

			if (false === ($email = Validate::email($email))) return 'USER_ERROR_EMAIL_INVALID';

            if ('' !== $password) {

    			if (false === ($password = Auth\Validate::userPassword($password))) return 'USER_ERROR_PASSWORD_INVALID';

    			if (0 !== strcmp($password, $password_retype)) return 'USER_ERROR_PASSWORD_MISMATCH';
            }

			# Check name exists

			$condition = ("name = '" . addslashes($name) . "' AND id != " . $this->entity->id);

			DB::select(TABLE_USERS, 'id', $condition, null, 1);

			if (!DB::last()->status) return 'USER_ERROR_EDIT';

			if (DB::last()->rows === 1) return 'USER_ERROR_NAME_DUPLICATE';

			# Check email exists

			$condition = ("email = '" . addslashes($email) . "' AND id != " . $this->entity->id);

			DB::select(TABLE_USERS, 'id', $condition, null, 1);

			if (!DB::last()->status) return 'USER_ERROR_EDIT';

			if (DB::last()->rows === 1) return 'USER_ERROR_EMAIL_DUPLICATE';

			# Encode password

			if ('' !== $password) { $auth_key = String::random(40); $password = String::encode($auth_key, $password); }

			else { $auth_key = $this->entity->auth_key; $password = $this->entity->password; }

			# Edit user

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
            $data['auth_key']           = $auth_key;
			$data['password']           = $password;

			if (!$this->entity->edit($data)) return 'USER_ERROR_EDIT';

			# ------------------------

			return true;
		}
	}
}
