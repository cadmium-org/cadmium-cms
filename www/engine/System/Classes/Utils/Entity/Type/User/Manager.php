<?php

namespace System\Utils\Entity\Type\User {

	use System\Utils\Entity, DB, Form, String, Validate;

	/**
	 * @property-read int $id
	 * @property-read int $rank
	 * @property-read string $name
	 * @property-read string $email
	 * @property-read string $auth_key
	 * @property-read string $password
	 * @property-read string $first_name
	 * @property-read string $last_name
	 * @property-read int $sex
	 * @property-read string $city
	 * @property-read string $country
	 * @property-read string $timezone
	 * @property-read int $time_registered
	 * @property-read int $time_logged
	 * @property-read string $full_name
	 */

	class Manager extends Entity\Manager {

		# Errors

		const ERROR_CREATE                  = 'USER_ERROR_CREATE';
		const ERROR_EDIT                    = 'USER_ERROR_EDIT';

		const ERROR_NAME_INVALID            = 'USER_ERROR_NAME_INVALID';
        const ERROR_NAME_DUPLICATE          = 'USER_ERROR_NAME_DUPLICATE';
		const ERROR_EMAIL_INVALID           = 'USER_ERROR_EMAIL_INVALID';
        const ERROR_EMAIL_DUPLICATE         = 'USER_ERROR_EMAIL_DUPLICATE';
		const ERROR_PASSWORD_INVALID        = 'USER_ERROR_PASSWORD_INVALID';
		const ERROR_PASSWORD_MISMATCH       = 'USER_ERROR_PASSWORD_MISMATCH';

        # Constructor

		public function __construct($id) {

			$this->entity = Entity\Factory::user($id);
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

			if (false === ($name = $this->entity->validateName($name))) return self::ERROR_NAME_INVALID;

			if (false === ($email = Validate::email($email))) return self::ERROR_EMAIL_INVALID;

			if (false === ($password = $this->entity->validatePassword($password))) return self::ERROR_PASSWORD_INVALID;

			if (0 !== strcmp($password, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;

			# Check name exists

			DB::select(TABLE_USERS, 'id', array('name' => $name), null, 1);

			if (!DB::last()->status) return self::ERROR_CREATE;

			if (DB::last()->rows === 1) return self::ERROR_NAME_DUPLICATE;

			# Check email exists

			DB::select(TABLE_USERS, 'id', array('email' => $email), null, 1);

			if (!DB::last()->status) return self::ERROR_CREATE;

			if (DB::last()->rows === 1) return self::ERROR_EMAIL_DUPLICATE;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password);

			# Create user

			$data = array();

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
			$data['time_registered']    = ENGINE_TIME;
			$data['time_logged']        = ENGINE_TIME;

            if (!$this->entity->create($data)) return self::ERROR_CREATE;

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

			if (false === ($name = $this->entity->validateName($name))) return self::ERROR_NAME_INVALID;

			if (false === ($email = Validate::email($email))) return self::ERROR_EMAIL_INVALID;

            if ('' !== $password) {

    			if (false === ($password = $this->entity->validatePassword($password))) return self::ERROR_PASSWORD_INVALID;

    			if (0 !== strcmp($password, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;
            }

			# Check name exists

			$condition = ("name = '" . addslashes($name) . "' AND id != " . $this->entity->id);

			DB::select(TABLE_USERS, 'id', $condition, null, 1);

			if (!DB::last()->status) return self::ERROR_EDIT;

			if (DB::last()->rows === 1) return self::ERROR_NAME_DUPLICATE;

			# Check email exists

			$condition = ("email = '" . addslashes($email) . "' AND id != " . $this->entity->id);

			DB::select(TABLE_USERS, 'id', $condition, null, 1);

			if (!DB::last()->status) return self::ERROR_EDIT;

			if (DB::last()->rows === 1) return self::ERROR_EMAIL_DUPLICATE;

			# Encode password

			if ('' !== $password) { $auth_key = String::random(40); $password = String::encode($auth_key, $password); }

			else { $auth_key = $this->entity->auth_key; $password = $this->entity->password; }

			# Edit user

			$data = array();

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

			if (!$this->entity->edit($data)) return self::ERROR_EDIT;

			# ------------------------

			return true;
		}
	}
}
