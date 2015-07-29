<?php

namespace System\Utils\Entity\Type\User {

	use System\Utils\Entity, DB, Form, String, Validate;

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

		public function create($fieldset) {

			if (false !== $this->entity->id) return true;

			# Check fieldset

			$fields = array('name', 'email', 'rank', 'first_name', 'last_name', 'sex',

			                'city', 'country', 'timezone', 'password', 'password_retype');

			foreach ($fields as $field) if (isset($fieldset[$field]) && ($fieldset[$field] instanceof Form\Utils\Field))

				$$field = $fieldset[$field]->value(); else return false;

			# Validate values

			if (false === ($name = $this->entity->validateName($name))) return self::ERROR_NAME_INVALID;

			if (false === ($email = Validate::email($email))) return self::ERROR_EMAIL_INVALID;

			if (false === ($password = $this->entity->validatePassword($password))) return self::ERROR_PASSWORD_INVALID;

			if (0 !== strcmp($password, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;

			# Check name exists

			DB::select(TABLE_USERS, 'id', array('name' => $name), false, 1);

			if (!DB::last()->status) return self::ERROR_CREATE;

			if (DB::last()->rows === 1) return self::ERROR_NAME_DUPLICATE;

			# Check email exists

			DB::select(TABLE_USERS, 'id', array('email' => $email), false, 1);

			if (!DB::last()->status) return self::ERROR_CREATE;

			if (DB::last()->rows === 1) return self::ERROR_EMAIL_DUPLICATE;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password);

			# Create user

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

		public function edit($fieldset) {

			if (false === $this->entity->id) return false;

			# Check fieldset

            $fields = array('name', 'email', 'rank', 'first_name', 'last_name', 'sex',

			                'city', 'country', 'timezone', 'password', 'password_retype');

			foreach ($fields as $field) if (isset($fieldset[$field]) && ($fieldset[$field] instanceof Form\Utils\Field))

				$$field = $fieldset[$field]->value(); else return false;

			# Validate values

			if (false === ($name = $this->entity->validateName($name))) return self::ERROR_NAME_INVALID;

			if (false === ($email = Validate::email($email))) return self::ERROR_EMAIL_INVALID;

            if (false !== $password) {

    			if (false === ($password = $this->entity->validatePassword($password))) return self::ERROR_PASSWORD_INVALID;

    			if (0 !== strcmp($password, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;
            }

			# Check name exists

			$condition = ("name = '" . addslashes($name) . "' AND id != " . $this->entity->id);

			DB::select(TABLE_USERS, 'id', $condition, false, 1);

			if (!DB::last()->status) return self::ERROR_EDIT;

			if (DB::last()->rows === 1) return self::ERROR_NAME_DUPLICATE;

			# Check email exists

			$condition = ("email = '" . addslashes($email) . "' AND id != " . $this->entity->id);

			DB::select(TABLE_USERS, 'id', $condition, false, 1);

			if (!DB::last()->status) return self::ERROR_EDIT;

			if (DB::last()->rows === 1) return self::ERROR_EMAIL_DUPLICATE;

			# Encode password

			if (false !== $password) { $auth_key = String::random(40); $password = String::encode($auth_key, $password); }

			else { $auth_key = $this->entity->auth_key; $password = $this->entity->password; }

			# Edit user

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

?>
