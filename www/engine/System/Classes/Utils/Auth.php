<?php

namespace System\Utils {

	use Date, DB, Explorer, Geo\Country, Geo\Timezone, Language, Mailer, Number, Request, Session, String, Template, Validate;

	abstract class Auth {

		# Errors

		const ERROR_NAME							= 'USER_ERROR_NAME';
		const ERROR_EMAIL							= 'USER_ERROR_EMAIL';

		const ERROR_AUTH_LOGIN	 					= 'USER_ERROR_AUTH_LOGIN';
		const ERROR_AUTH_RESET	 					= 'USER_ERROR_AUTH_RESET';
		const ERROR_AUTH_RECOVER					= 'USER_ERROR_AUTH_RECOVER';
		const ERROR_AUTH_REGISTER					= 'USER_ERROR_AUTH_REGISTER';

		const ERROR_EDIT_PERSONAL					= 'USER_ERROR_EDIT_PERSONAL';
		const ERROR_EDIT_PASSWORD					= 'USER_ERROR_EDIT_PASSWORD';

		const ERROR_ACCESS							= 'USER_ERROR_ACCESS';

		const ERROR_INPUT_NAME 						= 'USER_ERROR_INPUT_NAME';
		const ERROR_INPUT_NAME_INCORRECT 			= 'USER_ERROR_INPUT_NAME_INCORRECT';
		const ERROR_INPUT_NAME_INVALID 				= 'USER_ERROR_INPUT_NAME_INVALID';
		const ERROR_INPUT_EMAIL 					= 'USER_ERROR_INPUT_EMAIL';
		const ERROR_INPUT_EMAIL_INVALID 			= 'USER_ERROR_INPUT_EMAIL_INVALID';
		const ERROR_INPUT_PASSWORD 					= 'USER_ERROR_INPUT_PASSWORD';
		const ERROR_INPUT_PASSWORD_CURRENT			= 'USER_ERROR_INPUT_PASSWORD_CURRENT';
		const ERROR_INPUT_PASSWORD_INCORRECT		= 'USER_ERROR_INPUT_PASSWORD_INCORRECT';
		const ERROR_INPUT_PASSWORD_INVALID 			= 'USER_ERROR_INPUT_PASSWORD_INVALID';
		const ERROR_INPUT_PASSWORD_MISMATCH			= 'USER_ERROR_INPUT_PASSWORD_MISMATCH';
		const ERROR_INPUT_PASSWORD_NEW				= 'USER_ERROR_INPUT_PASSWORD_NEW';
		const ERROR_INPUT_PASSWORD_NEW_INVALID		= 'USER_ERROR_INPUT_PASSWORD_NEW_INVALID';
		const ERROR_INPUT_PASSWORD_RETYPE			= 'USER_ERROR_INPUT_PASSWORD_RETYPE';
		const ERROR_INPUT_CAPTCHA 					= 'USER_ERROR_INPUT_CAPTCHA';
		const ERROR_INPUT_CAPTCHA_INCORRECT 		= 'USER_ERROR_INPUT_CAPTCHA_INCORRECT';

		private static $user = false, $admin = false, $init = false;

		# Send reset mail

		private static function sendResetMail($email, $name, $code) {

			if (false === ($contents = Explorer::contents(DIR_SYSTEM_DATA . 'Mail/Reset.tpl'))) return false;

			$message = new Template\Utils\Block($contents);

			$message->site_title = CONFIG_SITE_TITLE; $message->system_url = CONFIG_SYSTEM_URL; $message->name = $name;

			$message->link = (CONFIG_SYSTEM_URL . (self::$admin ? '/admin/recover?code=' : '/profile/recover?code=') . $code);

			$message->system_email = CONFIG_SYSTEM_EMAIL; $message->copyright = Date::year();

			# ------------------------

			$sender = CONFIG_SITE_TITLE;

			$from = ((false !== ($host = parse_url(CONFIG_SYSTEM_URL, PHP_URL_HOST))) ? ('noreply@' . $host) : false);

			$reply_to = CONFIG_SYSTEM_EMAIL; $subject = Language::get('MAIL_SUBJECT_RESET');

			return Mailer::send($email, $sender, $from, $reply_to, $subject, $message->contents(), true);
		}

		# Send register mail

		private static function sendRegisterMail($email, $name) {

			if (false === ($contents = Explorer::contents(DIR_SYSTEM_DATA . 'Mail/Register.tpl'))) return false;

			$message = new Template\Utils\Block($contents);

			$message->site_title = CONFIG_SITE_TITLE; $message->system_url = CONFIG_SYSTEM_URL; $message->name = $name;

			$message->link = (CONFIG_SYSTEM_URL . (self::$admin ? '/admin' : '/profile'));

			$message->system_email = CONFIG_SYSTEM_EMAIL; $message->copyright = Date::year();

			# ------------------------

			$sender = CONFIG_SITE_TITLE;

			$from = ((false !== ($host = parse_url(CONFIG_SYSTEM_URL, PHP_URL_HOST))) ? ('noreply@' . $host) : false);

			$reply_to = CONFIG_SYSTEM_EMAIL; $subject = Language::get('MAIL_SUBJECT_REGISTER');

			return Mailer::send($email, $sender, $from, $reply_to, $subject, $message->contents(), true);
		}

		# Validate data

		private static function validateData($data) {

			$data['id']					= Number::unsigned($data['id']);

			$data['rank']				= Number::unsigned($data['rank']);

			$data['name']				= String::validate($data['name']);

			$data['email']				= String::validate($data['email']);

			$data['auth_key']			= String::validate($data['auth_key']);

			$data['password']			= String::validate($data['password']);

			$data['first_name']			= String::validate($data['first_name']);

			$data['last_name']			= String::validate($data['last_name']);

			$data['sex']				= Number::unsigned($data['sex']);

			$data['city']				= String::validate($data['city']);

			$data['country']			= String::validate($data['country']);

			$data['timezone']			= String::validate($data['timezone']);

			$data['time_registered']	= Number::unsigned($data['time_registered']);

			$data['time_logged']		= Number::unsigned($data['time_logged']);

			# ------------------------

			return $data;
		}

		# Validate auth code

		private static function validateCode($code) {

			$code = String::validate($code);

			return (preg_match(REGEX_USER_AUTH_CODE, $code) ? $code : false);
		}

		# Check captcha

		private static function checkCaptcha($captcha) {

			return (0 === strcasecmp(Session::get(USER_SESSION_PARAM_CAPTCHA), $captcha));
		}

		# Autoloader

		public static function __autoload() {

			self::$user = new Entity\User();
		}

		# Authorize with session code

		public static function init($admin = false) {

			if (false !== self::$user->id()) return true;

			self::$admin = Validate::boolean($admin);

			if (false === ($code = self::validateCode(Session::get(USER_SESSION_PARAM_CODE)))) return false;

			# Select user from DB

			$rank = (self::$admin ? RANK_ADMINISTRATOR : RANK_USER);

			$ip = addslashes(ENGINE_CLIENT_IP); $time = (ENGINE_TIME - CONFIG_USER_SESSION_LIFETIME);

			$query = ("SELECT usr.id FROM " . TABLE_USERS_SESSIONS . " ses ") .

					 ("INNER JOIN " . TABLE_USERS . " usr ON usr.id = ses.id AND usr.rank >= " . $rank . " ") .

					 ("WHERE ses.code = '" . $code . "' AND ses.ip = '" . $ip . "' AND ses.time > " . $time . " LIMIT 1");

			if (!(DB::send($query) && (DB::last()->rows === 1))) return false;

			if (!self::$user->init(DB::last()->row()['id'])) return false;

			# Update session

			DB::update(TABLE_USERS_SESSIONS, array('time' => ENGINE_TIME), array('id' => self::$user->id()));

			# Update activity

			DB::update(TABLE_USERS, array('time_logged' => ENGINE_TIME), array('id' => self::$user->id()));

			# ------------------------

			return (self::$init = true);
		}

		# Authorize with secret code

		public static function secret($admin = false) {

			if (false !== self::$user->id()) return true;

			self::$admin = Validate::boolean($admin);

			if (false === ($code = self::validateCode(Request::get(USER_SECRET_PARAM_CODE)))) return false;

			# Select user from DB

			$rank = (self::$admin ? RANK_ADMINISTRATOR : RANK_USER);

			$ip = addslashes(ENGINE_CLIENT_IP); $time = (ENGINE_TIME - CONFIG_USER_SECRET_LIFETIME);

			$query = ("SELECT usr.id FROM " . TABLE_USERS_SECRETS . " sec ") .

					 ("INNER JOIN " . TABLE_USERS . " usr ON usr.id = sec.id AND usr.rank >= " . $rank . " ") .

					 ("WHERE sec.code = '" . $code . "' AND sec.ip = '" . $ip . "' AND sec.time > " . $time . " LIMIT 1");

			if (!(DB::send($query) && (DB::last()->rows === 1))) return false;

			if (!self::$user->init(DB::last()->row()['id'])) return false;

			# ------------------------

			return $code;
		}

		# Generate and return captcha

		public static function captcha() {

			$code = String::random(CONFIG_CAPTCHA_LENGTH, STRING_POOL_LATIN_UPPER);

			Session::set(USER_SESSION_PARAM_CAPTCHA, $code);

			# ------------------------

			return $code;
		}

		# Create new session

		public static function login($data) {

			if (false !== self::$user->id()) return true;

			# Check dataset

			$dataset = array('name', 'password');

			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;

			# Check values

			if (false === ($name = String::validate($name))) return self::ERROR_INPUT_NAME;

			if (false === ($password = String::validate($password))) return self::ERROR_INPUT_PASSWORD;

			# Validate values

			if (false === ($name = self::$user->validateName($name))) return self::ERROR_INPUT_NAME_INVALID;

			if (false === ($password = self::$user->validatePassword($password))) return self::ERROR_INPUT_PASSWORD_INVALID;

			# Select user from DB

			if (!self::$user->initByName($name)) return self::ERROR_INPUT_NAME_INCORRECT;

			if (self::$admin && (self::$user->rank() < RANK_ADMINISTRATOR)) return self::ERROR_INPUT_NAME_INCORRECT;

			# Check password

			$password = String::encode(self::$user->authKey(), $password);

			if (0 !== strcmp(self::$user->password(), $password)) return self::ERROR_INPUT_PASSWORD_INCORRECT;

			# Check access

			if (self::$user->rank() === RANK_GUEST) return self::ERROR_ACCESS;

			# Create session

			$id = self::$user->id(); $code = String::random(40); $ip = ENGINE_CLIENT_IP; $time = ENGINE_TIME;

			DB::delete(TABLE_USERS_SESSIONS, array('id' => $id));

			$set = array('id' => $id, 'code' => $code, 'ip' => $ip, 'time' => $time);

			if (!(DB::insert(TABLE_USERS_SESSIONS, $set) && (DB::last()->status))) return self::ERROR_AUTH_LOGIN;

			Session::set(USER_SESSION_PARAM_CODE, $code);

			# ------------------------

			return true;
		}

		# Create new secret

		public static function reset($data) {

			if (false !== self::$user->id()) return true;

			# Check dataset

			$dataset = array('name', 'captcha');

			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;

			# Check values

			if (false === ($name = String::validate($name))) return self::ERROR_INPUT_NAME;

			if (false === ($captcha = String::validate($captcha))) return self::ERROR_INPUT_CAPTCHA;

			# Validate values

			if (false === ($name = self::$user->validateName($name))) return self::ERROR_INPUT_NAME_INVALID;

			if (false === self::checkCaptcha($captcha)) return self::ERROR_INPUT_CAPTCHA_INCORRECT;

			# Select user from DB

			if (!self::$user->initByName($name)) return self::ERROR_INPUT_NAME_INCORRECT;

			if (self::$admin && (self::$user->rank() < RANK_ADMINISTRATOR)) return self::ERROR_INPUT_NAME_INCORRECT;

			# Check access

			if (self::$user->rank() === RANK_GUEST) return self::ERROR_ACCESS;

			# Create secret

			$id = self::$user->id(); $code = String::random(40); $ip = ENGINE_CLIENT_IP; $time = ENGINE_TIME;

			DB::delete(TABLE_USERS_SECRETS, array('id' => $id));

			$set = array('id' => $id, 'code' => $code, 'ip' => $ip, 'time' => $time);

			if (!(DB::insert(TABLE_USERS_SECRETS, $set) && (DB::last()->status))) return self::ERROR_AUTH_RESET;

			# Send mail

			self::sendResetMail(self::$user->email(), self::$user->name(), $code);

			# ------------------------

			return true;
		}

		# Recover password

		public static function recover($data) {

			if (false === self::$user->id()) return false;

			# Check dataset

			$dataset = array('password_new', 'password_retype');

			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;

			# Check values

			if (false === ($password_new = String::validate($password_new))) return self::ERROR_INPUT_PASSWORD_NEW;

			if (false === ($password_retype = String::validate($password_retype))) return self::ERROR_INPUT_PASSWORD_RETYPE;

			# Validate values

			if (false === ($password_new = self::$user->validatePassword($password_new))) return self::ERROR_INPUT_PASSWORD_NEW_INVALID;

			if (0 !== strcmp($password_new, $password_retype)) return self::ERROR_INPUT_PASSWORD_MISMATCH;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password_new);

			# Update user

			$set['auth_key']			= $auth_key;
			$set['password']			= $password;

			$condition = array('id' => self::$user->id());

			if (!(DB::update(TABLE_USERS, $set, $condition) && (DB::last()->status))) return self::ERROR_AUTH_RECOVER;

			# Remove secret

			DB::delete(TABLE_USERS_SECRETS, array('id' => self::$user->id()));

			# ------------------------

			return true;
		}

		# Create new user

		public static function register($data) {

			if (false !== self::$user->id()) return true;

			# Check dataset

			$dataset = array('name', 'password', 'password_retype', 'email', 'captcha');

			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;

			# Check values

			if (false === ($name = String::validate($name))) return self::ERROR_INPUT_NAME;

			if (false === ($password = String::validate($password))) return self::ERROR_INPUT_PASSWORD;

			if (false === ($password_retype = String::validate($password_retype))) return self::ERROR_INPUT_PASSWORD_RETYPE;

			if (false === ($email = String::validate($email))) return self::ERROR_INPUT_EMAIL;

			if (false === ($captcha = String::validate($captcha))) return self::ERROR_INPUT_CAPTCHA;

			# Validate values

			if (false === ($name = self::$user->validateName($name))) return self::ERROR_INPUT_NAME_INVALID;

			if (false === ($password = self::$user->validatePassword($password))) return self::ERROR_INPUT_PASSWORD_INVALID;

			if (false === ($email = Validate::email($email))) return self::ERROR_INPUT_EMAIL_INVALID;

			if (0 !== strcmp($password, $password_retype)) return self::ERROR_INPUT_PASSWORD_MISMATCH;

			if (false === self::checkCaptcha($captcha)) return self::ERROR_INPUT_CAPTCHA_INCORRECT;

			# Check name exists

			DB::select(TABLE_USERS, 'id', array('name' => $name), false, 1);

			if (!DB::last()->status) return self::ERROR_AUTH_REGISTER;

			if (DB::last()->rows === 1) return self::ERROR_NAME;

			# Check email exists

			DB::select(TABLE_USERS, 'id', array('email' => $email), false, 1);

			if (!DB::last()->status) return self::ERROR_AUTH_REGISTER;

			if (DB::last()->rows === 1) return self::ERROR_EMAIL;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password);

			# Insert user to DB

			$rank = (self::$admin ? RANK_ADMINISTRATOR : RANK_USER);

			$set['rank']				= $rank;
			$set['name']				= $name;
			$set['email']				= $email;
			$set['auth_key']			= $auth_key;
			$set['password']			= $password;
			$set['time_registered']		= ENGINE_TIME;
			$set['time_logged']			= ENGINE_TIME;

			if (!(DB::insert(TABLE_USERS, $set) && (DB::last()->status))) return self::ERROR_AUTH_REGISTER;

			# Send mail

			self::sendRegisterMail($email, $name);

			# ------------------------

			return true;
		}

		# Edit personal data

		public static function editPersonal($data) {

			if (false === self::$user->id()) return false;

			# Check dataset

			$dataset = array('email', 'first_name', 'last_name', 'sex', 'city', 'country', 'timezone');

			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;

			# Check values

			if (false === ($email = String::validate($email))) return self::ERROR_INPUT_EMAIL;

			# Validate values

			if (false === ($email = Validate::email($email))) return self::ERROR_INPUT_EMAIL_INVALID;

			$first_name = String::validate($data['first_name']); $last_name = String::validate($data['last_name']);

			$sex = Number::unsigned(Lister::sex($data['sex'], true)); $city = String::validate($data['city']);

			$country = Country::validate($data['country']); $timezone = Timezone::validate($data['timezone']);

			# Check email exists

			$condition = ("email = '" . addslashes($email) . "' AND id != " . self::$user->id());

			DB::select(TABLE_USERS, 'id', $condition, false, 1);

			if (!DB::last()->status) return self::ERROR_EDIT_PERSONAL;

			if (DB::last()->rows === 1) return self::ERROR_EMAIL;

			# Update user

			$set['email']				= $email;
			$set['first_name']			= $first_name;
			$set['last_name']			= $last_name;
			$set['sex']					= $sex;
			$set['city']				= $city;
			$set['country']				= $country;
			$set['timezone']			= $timezone;

			$condition = array('id' => self::$user->id());

			if (!(DB::update(TABLE_USERS, $set, $condition) && (DB::last()->status))) return self::ERROR_EDIT_PERSONAL;

			# ------------------------

			return true;
		}

		# Edit password data

		public static function editPassword($data) {

			if (false === self::$user->id()) return false;

			# Check dataset

			$dataset = array('password', 'password_new', 'password_retype');

			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;

			# Check values

			if (false === ($password = String::validate($password))) return self::ERROR_INPUT_PASSWORD_CURRENT;

			if (false === ($password_new = String::validate($password_new))) return self::ERROR_INPUT_PASSWORD_NEW;

			if (false === ($password_retype = String::validate($password_retype))) return self::ERROR_INPUT_PASSWORD_RETYPE;

			# Validate values

			if (false === ($password = self::$user->validatePassword($password))) return self::ERROR_INPUT_PASSWORD_INVALID;

			if (false === ($password_new = self::$user->validatePassword($password_new))) return self::ERROR_INPUT_PASSWORD_NEW_INVALID;

			if (0 !== strcmp($password_new, $password_retype)) return self::ERROR_INPUT_PASSWORD_MISMATCH;

			# Check password

			$password = String::encode(self::$user->authKey(), $password);

			if (0 !== strcmp(self::$user->password(), $password)) return self::ERROR_INPUT_PASSWORD_INCORRECT;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password_new);

			# Update user

			$set['auth_key']			= $auth_key;
			$set['password']			= $password;

			$condition = array('id' => self::$user->id());

			if (!(DB::update(TABLE_USERS, $set, $condition) && (DB::last()->status))) return self::ERROR_EDIT_PASSWORD;

			# ------------------------

			return true;
		}

		# Delete session

		public static function logout() {

			if (false === self::$user->id()) return false;

			DB::delete(TABLE_USERS_SESSIONS, array('id' => self::$user->id()));

			Session::delete(USER_SESSION_PARAM_CODE);

			# ------------------------

			return true;
		}

		# Return user object

		public static function user() {

			return self::$user;
		}

		# Check if authorized

		public static function check() {

			return self::$init;
		}
	}
}

?>
