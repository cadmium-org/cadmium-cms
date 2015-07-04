<?php

namespace System\Utils\Entity {

	use System\Utils\Auth, System\Utils\Lister, DB, Geo\Country, Geo\Timezone, Number, String, Validate;

	class User {

		# Errors

		const ERROR_NAME							= 'USER_ERROR_NAME';
		const ERROR_EMAIL							= 'USER_ERROR_EMAIL';

		const ERROR_SAVE							= 'USER_ERROR_SAVE';

		const ERROR_INPUT_NAME 						= 'USER_ERROR_INPUT_NAME';
		const ERROR_INPUT_NAME_INVALID 				= 'USER_ERROR_INPUT_NAME_INVALID';
		const ERROR_INPUT_EMAIL 					= 'USER_ERROR_INPUT_EMAIL';
		const ERROR_INPUT_EMAIL_INVALID 			= 'USER_ERROR_INPUT_EMAIL_INVALID';
		const ERROR_INPUT_PASSWORD 					= 'USER_ERROR_INPUT_PASSWORD';
		const ERROR_INPUT_PASSWORD_INVALID 			= 'USER_ERROR_INPUT_PASSWORD_INVALID';
		const ERROR_INPUT_PASSWORD_MISMATCH			= 'USER_ERROR_INPUT_PASSWORD_MISMATCH';
		const ERROR_INPUT_PASSWORD_RETYPE			= 'USER_ERROR_INPUT_PASSWORD_RETYPE';

		# Entity data

		private $user = false;

		# Validate data

		private function validateUser($data) {

			$user['id']					= Number::unsigned($data['id']);

			$user['rank']				= Number::unsigned($data['rank']);

			$user['name']				= String::validate($data['name']);

			$user['email']				= String::validate($data['email']);

			$user['auth_key']			= String::validate($data['auth_key']);

			$user['password']			= String::validate($data['password']);

			$user['first_name']			= String::validate($data['first_name']);

			$user['last_name']			= String::validate($data['last_name']);

			$user['sex']				= Number::unsigned($data['sex']);

			$user['city']				= String::validate($data['city']);

			$user['country']			= String::validate($data['country']);

			$user['timezone']			= String::validate($data['timezone']);

			$user['time_registered']	= Number::unsigned($data['time_registered']);

			$user['time_logged']		= Number::unsigned($data['time_logged']);

			# ------------------------

			return $user;
		}

		# Validate name

		public static function validateName($name) {

			$name = String::validate($name);

			if (!preg_match(REGEX_USER_NAME, $name)) return false;

			$min = CONFIG_USER_NAME_MIN_LENGTH; $max = CONFIG_USER_NAME_MAX_LENGTH;

			# ------------------------

			return (preg_match(('/^(?=.{' . $min . ',' . $max . '}$).+$/'), $name) ? $name : false);
		}

		# Validate password

		public static function validatePassword($password) {

			$password = String::validate($password);

			if (!preg_match(REGEX_USER_PASSWORD, $password)) return false;

			$min = CONFIG_USER_PASSWORD_MIN_LENGTH; $max = CONFIG_USER_PASSWORD_MAX_LENGTH;

			# ------------------------

			return (preg_match(('/^(?=.{' . $min . ',' . $max . '}$).+$/'), $password) ? $password : false);
		}

		# Init user with id

		public function init($id) {

			if (false !== $this->user) return true;

			if (0 === ($id = Number::unsigned($id))) return false;

			# Select user from DB

			$query = ("SELECT usr.id, usr.rank, usr.name, usr.email, usr.auth_key, usr.password, ") .

					 ("usr.first_name, usr.last_name, usr.sex, usr.city, usr.country, usr.timezone, ") .

					 ("usr.time_registered, usr.time_logged ") .

					 ("FROM " . TABLE_USERS . " usr WHERE usr.id = " . $id . " LIMIT 1");

			if (!(DB::send($query) && (DB::last()->rows === 1))) return false;

			if (false === ($this->user = $this->validateUser(DB::last()->row()))) return false;

			# ------------------------

			return true;
		}

		public function initByName($name) {

			if (false !== $this->user) return true;

			if (false === ($name = String::validate($name))) return false;

			# Select user from DB

			$query = ("SELECT usr.id, usr.rank, usr.name, usr.email, usr.auth_key, usr.password, ") .

					 ("usr.first_name, usr.last_name, usr.sex, usr.city, usr.country, usr.timezone, ") .

					 ("usr.time_registered, usr.time_logged ") .

					 ("FROM " . TABLE_USERS . " usr WHERE usr.name = '" . addslashes($name) . "' LIMIT 1");

			if (!(DB::send($query) && (DB::last()->rows === 1))) return false;

			if (false === ($this->user = $this->validateUser(DB::last()->row()))) return false;

			# ------------------------

			return true;
		}

		# Create user

		public function create($data) {

			if (false !== $this->user) return true;

			# Check dataset

			$dataset = array('name', 'email', 'rank', 'first_name', 'last_name', 'sex',

							 'city', 'country', 'timezone', 'password', 'password_retype');

			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;

			# Check values

			if (false === ($name = String::validate($name))) return self::ERROR_INPUT_NAME;

			if (false === ($email = String::validate($email))) return self::ERROR_INPUT_EMAIL;

			if (false === ($password = String::validate($password))) return self::ERROR_INPUT_PASSWORD;

			if (false === ($password_retype = String::validate($password_retype))) return self::ERROR_INPUT_PASSWORD_RETYPE;

			# Validate values

			if (false === ($name = self::validateName($name))) return self::ERROR_INPUT_NAME_INVALID;

			if (false === ($email = Validate::email($email))) return self::ERROR_INPUT_EMAIL_INVALID;

			$rank = Number::unsigned(Lister::rank($rank, true));

			$first_name = String::validate($data['first_name']); $last_name = String::validate($data['last_name']);

			$sex = Number::unsigned(Lister::sex($data['sex'], true)); $city = String::validate($data['city']);

			$country = Country::validate($data['country']); $timezone = Timezone::validate($data['timezone']);

			if (false === ($password = self::validatePassword($password))) return self::ERROR_INPUT_PASSWORD_INVALID;

			if (0 !== strcmp($password, $password_retype)) return self::ERROR_INPUT_PASSWORD_MISMATCH;

			# Check name exists

			DB::select(TABLE_USERS, 'id', array('name' => $name), false, 1);

			if (!DB::last()->status) return self::ERROR_SAVE;

			if (DB::last()->rows === 1) return self::ERROR_NAME;

			# Check email exists

			DB::select(TABLE_USERS, 'id', array('email' => $email), false, 1);

			if (!DB::last()->status) return self::ERROR_SAVE;

			if (DB::last()->rows === 1) return self::ERROR_EMAIL;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password);

			# Insert user

			$set['rank']				= $rank;
			$set['name']				= $name;
			$set['email']				= $email;
			$set['auth_key']			= $auth_key;
			$set['password']			= $password;
			$set['first_name']			= $first_name;
			$set['last_name']			= $last_name;
			$set['sex']					= $sex;
			$set['city']				= $city;
			$set['country']				= $country;
			$set['timezone']			= $timezone;
			$set['time_registered']		= ENGINE_TIME;
			$set['time_logged']			= ENGINE_TIME;

			if (!(DB::insert(TABLE_USERS, $set) && (DB::last()->status))) return self::ERROR_SAVE;

			# Init user

			$this->user['id'] = DB::last()->id;

			foreach ($set as $name => $value) $this->user[$name] = $value;

			# ------------------------

			return true;
		}

		# Edit user

		public function edit($data) {

			if (false === $this->user) return false;

			# Check dataset

			$dataset = array('name', 'email', 'rank', 'first_name', 'last_name', 'sex',

							 'city', 'country', 'timezone', 'password', 'password_retype');

			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;

			# Check values

			if (false === ($name = String::validate($name))) return self::ERROR_INPUT_NAME;

			if (false === ($email = String::validate($email))) return self::ERROR_INPUT_EMAIL;

			# Validate values

			if (false === ($name = self::validateName($name))) return self::ERROR_INPUT_NAME_INVALID;

			if (false === ($email = Validate::email($email))) return self::ERROR_INPUT_EMAIL_INVALID;

			$rank = Number::unsigned(Lister::rank($rank, true));

			$first_name = String::validate($data['first_name']); $last_name = String::validate($data['last_name']);

			$sex = Number::unsigned(Lister::sex($data['sex'], true)); $city = String::validate($data['city']);

			$country = Country::validate($data['country']); $timezone = Timezone::validate($data['timezone']);

			$password = String::validate($password); $password_retype = String::validate($password_retype);

			if ((false !== $password) && (false === $password_retype)) return self::ERROR_INPUT_PASSWORD_RETYPE;

			if ((false !== $password) && (false === ($password = self::validatePassword($password)))) return self::ERROR_INPUT_PASSWORD_INVALID;

			if ((false !== $password) && (0 !== strcmp($password, $password_retype))) return self::ERROR_INPUT_PASSWORD_MISMATCH;

			# Check name exists

			$condition = ("name = '" . addslashes($name) . "' AND id != " . $this->user['id']);

			DB::select(TABLE_USERS, 'id', $condition, false, 1);

			if (!DB::last()->status) return self::ERROR_SAVE;

			if (DB::last()->rows === 1) return self::ERROR_NAME;

			# Check email exists

			$condition = ("email = '" . addslashes($email) . "' AND id != " . $this->user['id']);

			DB::select(TABLE_USERS, 'id', $condition, false, 1);

			if (!DB::last()->status) return self::ERROR_SAVE;

			if (DB::last()->rows === 1) return self::ERROR_EMAIL;

			# Encode password

			if (false !== $password) { $auth_key = String::random(40); $password = String::encode($auth_key, $password); }

			else { $auth_key = $this->user['auth_key']; $password = $this->user['password']; }

			# Insert user

			$set['rank']				= $rank;
			$set['name']				= $name;
			$set['email']				= $email;
			$set['auth_key']			= $auth_key;
			$set['password']			= $password;
			$set['first_name']			= $first_name;
			$set['last_name']			= $last_name;
			$set['sex']					= $sex;
			$set['city']				= $city;
			$set['country']				= $country;
			$set['timezone']			= $timezone;

			$condition = array('id' => $this->user['id']);

			if (!(DB::update(TABLE_USERS, $set, $condition) && DB::last()->status)) return self::ERROR_SAVE;

			# Init user

			foreach ($set as $name => $value) $this->user[$name] = $value;

			# ------------------------

			return true;
		}

		# Remove user

		public function remove() {

			if (false === $this->user) return false;

			if ($this->user['id'] === Auth::user()->id()) return false;

			$condition = array('id' => $this->user['id']);

			# Remove data

			DB::delete(TABLE_USERS_SESSIONS, $condition);

			DB::delete(TABLE_USERS_SECRETS, $condition);

			if (!(DB::delete(TABLE_USERS, $condition) && DB::last()->status)) return false;

			$this->user = false;

			# ------------------------

			return true;
		}

		# Return id

		public function id() {

			if (false === $this->user) return false;

			return $this->user['id'];
		}

		# Return rank

		public function rank() {

			if (false === $this->user) return RANK_GUEST;

			# ------------------------

			return $this->user['rank'];
		}

		# Return name

		public function name() {

			if (false === $this->user) return false;

			return $this->user['name'];
		}

		# Return email

		public function email() {

			if (false === $this->user) return false;

			return $this->user['email'];
		}

		# Return auth key

		public function authKey() {

			if (false === $this->user) return false;

			return $this->user['auth_key'];
		}

		# Return password

		public function password() {

			if (false === $this->user) return false;

			return $this->user['password'];
		}

		# Return first name

		public function firstName() {

			if (false === $this->user) return false;

			return $this->user['first_name'];
		}

		# Return last name

		public function lastName() {

			if (false === $this->user) return false;

			return $this->user['last_name'];
		}

		# Return full name

		public function fullName() {

			if (false === $this->user) return false;

			return trim($this->user['first_name'] . ' ' . $this->user['last_name']);
		}

		# Return sex

		public function sex() {

			if (false === $this->user) return false;

			return $this->user['sex'];
		}

		# Return city

		public function city() {

			if (false === $this->user) return false;

			return $this->user['city'];
		}

		# Return country

		public function country() {

			if (false === $this->user) return false;

			return $this->user['country'];
		}

		# Return timezone

		public function timezone() {

			if (false === $this->user) return false;

			return $this->user['timezone'];
		}

		# Return time registered

		public function timeRegistered() {

			if (false === $this->user) return false;

			return $this->user['time_registered'];
		}

		# Return time logged

		public function timeLogged() {

			if (false === $this->user) return false;

			return $this->user['time_logged'];
		}
	}
}

?>
