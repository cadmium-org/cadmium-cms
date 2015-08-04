<?php

namespace System\Utils {

	use Date, DB, Explorer, Form, Language, Mailer, Request, Session, String, Template, Validate;

	abstract class Auth {

		# Errors

		const ERROR_AUTH_LOGIN                      = 'USER_ERROR_AUTH_LOGIN';
		const ERROR_AUTH_RESET                      = 'USER_ERROR_AUTH_RESET';
		const ERROR_AUTH_RECOVER                    = 'USER_ERROR_AUTH_RECOVER';
		const ERROR_AUTH_REGISTER                   = 'USER_ERROR_AUTH_REGISTER';

		const ERROR_EDIT_PERSONAL                   = 'USER_ERROR_EDIT_PERSONAL';
		const ERROR_EDIT_PASSWORD                   = 'USER_ERROR_EDIT_PASSWORD';

		const ERROR_NAME_INVALID                    = 'USER_ERROR_NAME_INVALID';
		const ERROR_NAME_INCORRECT                  = 'USER_ERROR_NAME_INCORRECT';
		const ERROR_NAME_DUPLICATE                  = 'USER_ERROR_NAME_DUPLICATE';
		const ERROR_EMAIL_INVALID                   = 'USER_ERROR_EMAIL_INVALID';
		const ERROR_EMAIL_DUPLICATE                 = 'USER_ERROR_EMAIL_DUPLICATE';
		const ERROR_PASSWORD_INVALID                = 'USER_ERROR_PASSWORD_INVALID';
		const ERROR_PASSWORD_INCORRECT              = 'USER_ERROR_PASSWORD_INCORRECT';
		const ERROR_PASSWORD_MISMATCH               = 'USER_ERROR_PASSWORD_MISMATCH';
		const ERROR_PASSWORD_NEW_INVALID            = 'USER_ERROR_PASSWORD_NEW_INVALID';
		const ERROR_CAPTCHA_INCORRECT               = 'USER_ERROR_CAPTCHA_INCORRECT';

		const ERROR_ACCESS                          = 'USER_ERROR_ACCESS';

		private static $user = null, $admin = false, $init = false;

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

		# Validate auth code

		private static function validateCode($code) {

			$code = strval($code);

			return (preg_match(REGEX_USER_AUTH_CODE, $code) ? $code : false);
		}

		# Check captcha

		private static function checkCaptcha($captcha) {

			return (0 === strcasecmp(Session::get(USER_SESSION_PARAM_CAPTCHA), $captcha));
		}

		# Autoloader

		public static function __autoload() {

			self::$user = Entity\Factory::user();
		}

		# Authorize with session code

		public static function session($admin = false) {

			if (0 !== self::$user->id) return true;

			self::$admin = boolval($admin);

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

			DB::update(TABLE_USERS_SESSIONS, array('time' => ENGINE_TIME), array('id' => self::$user->id));

			# Update activity

			DB::update(TABLE_USERS, array('time_logged' => ENGINE_TIME), array('id' => self::$user->id));

			# ------------------------

			return (self::$init = true);
		}

		# Authorize with secret code

		public static function secret($admin = false) {

			if (0 !== self::$user->id) return true;

			self::$admin = boolval($admin);

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

		public static function login($post) {

			if (0 !== self::$user->id) return true;

			# Declare variables

			$name = null; $password = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = self::$user->validateName($name))) return self::ERROR_NAME_INVALID;

			if (false === ($password = self::$user->validatePassword($password))) return self::ERROR_PASSWORD_INVALID;

			# Select user from DB

			if (!self::$user->initBy('name', $name)) return self::ERROR_NAME_INCORRECT;

			if (self::$admin && (self::$user->rank < RANK_ADMINISTRATOR)) return self::ERROR_NAME_INCORRECT;

			# Check password

			$password = String::encode(self::$user->auth_key, $password);

			if (0 !== strcmp(self::$user->password, $password)) return self::ERROR_PASSWORD_INCORRECT;

			# Check access

			if (!self::$admin && (self::$user->rank === RANK_GUEST)) return self::ERROR_ACCESS;

			# Create session

			$id = self::$user->id; $code = String::random(40); $ip = ENGINE_CLIENT_IP; $time = ENGINE_TIME;

			DB::delete(TABLE_USERS_SESSIONS, array('id' => $id));

			$set = array('id' => $id, 'code' => $code, 'ip' => $ip, 'time' => $time);

			if (!(DB::insert(TABLE_USERS_SESSIONS, $set) && (DB::last()->status))) return self::ERROR_AUTH_LOGIN;

			Session::set(USER_SESSION_PARAM_CODE, $code);

			# ------------------------

			return true;
		}

		# Create new secret

		public static function reset($post) {

			if (0 !== self::$user->id) return true;

			# Declare variables

			$name = null; $captcha = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = self::$user->validateName($name))) return self::ERROR_NAME_INVALID;

			if (false === self::checkCaptcha($captcha)) return self::ERROR_CAPTCHA_INCORRECT;

			# Select user from DB

			if (!self::$user->initBy('name', $name)) return self::ERROR_NAME_INCORRECT;

			if (self::$admin && (self::$user->rank < RANK_ADMINISTRATOR)) return self::ERROR_NAME_INCORRECT;

			# Check access

			if (!self::$admin && (self::$user->rank === RANK_GUEST)) return self::ERROR_ACCESS;

			# Create secret

			$id = self::$user->id; $code = String::random(40); $ip = ENGINE_CLIENT_IP; $time = ENGINE_TIME;

			DB::delete(TABLE_USERS_SECRETS, array('id' => $id));

			$set = array('id' => $id, 'code' => $code, 'ip' => $ip, 'time' => $time);

			if (!(DB::insert(TABLE_USERS_SECRETS, $set) && (DB::last()->status))) return self::ERROR_AUTH_RESET;

			# Send mail

			self::sendResetMail(self::$user->email, self::$user->name, $code);

			# ------------------------

			return true;
		}

		# Recover password

		public static function recover($post) {

			if (0 === self::$user->id) return false;

			# Declare variables

			$password_new = null; $password_retype = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($password_new = self::$user->validatePassword($password_new))) return self::ERROR_PASSWORD_NEW_INVALID;

			if (0 !== strcmp($password_new, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password_new);

			# Update user

			$data = array();

			$data['auth_key']           = $auth_key;
			$data['password']           = $password;

			if (!self::$user->edit($data)) return self::ERROR_AUTH_RECOVER;

			# Remove secret

			DB::delete(TABLE_USERS_SECRETS, array('id' => self::$user->id));

			# ------------------------

			return true;
		}

		# Create new user

		public static function register($post) {

			if (0 !== self::$user->id) return true;

			# Declare variables

			$name = null; $password = null; $password_retype = null; $email = null; $captcha = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = self::$user->validateName($name))) return self::ERROR_NAME_INVALID;

			if (false === ($password = self::$user->validatePassword($password))) return self::ERROR_PASSWORD_INVALID;

			if (false === ($email = Validate::email($email))) return self::ERROR_EMAIL_INVALID;

			if (0 !== strcmp($password, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;

			if (false === self::checkCaptcha($captcha)) return self::ERROR_CAPTCHA_INCORRECT;

			# Check name exists

			DB::select(TABLE_USERS, 'id', array('name' => $name), null, 1);

			if (!DB::last()->status) return self::ERROR_AUTH_REGISTER;

			if (DB::last()->rows === 1) return self::ERROR_NAME_DUPLICATE;

			# Check email exists

			DB::select(TABLE_USERS, 'id', array('email' => $email), null, 1);

			if (!DB::last()->status) return self::ERROR_AUTH_REGISTER;

			if (DB::last()->rows === 1) return self::ERROR_EMAIL_DUPLICATE;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password);

			# Determine rank

			$rank = (self::$admin ? RANK_ADMINISTRATOR : RANK_USER);

			# Create user

			$data = array();

			$data['name']               = $name;
			$data['email']              = $email;
			$data['auth_key']           = $auth_key;
			$data['password']           = $password;
			$data['rank']               = $rank;
			$data['time_registered']    = ENGINE_TIME;
			$data['time_logged']        = ENGINE_TIME;

			if (!self::$user->create($data)) return self::ERROR_AUTH_REGISTER;

			# Send mail

			self::sendRegisterMail(self::$user->email, self::$user->name);

			# ------------------------

			return true;
		}

		# Edit personal data

		public static function editPersonal($post) {

			if (0 === self::$user->id) return false;

			# Declare variables

			$email = null; $first_name = null; $last_name = null; $sex = null;

			$city = null; $country = null; $timezone = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($email = Validate::email($email))) return self::ERROR_EMAIL_INVALID;

			# Check email exists

			$condition = ("email = '" . addslashes($email) . "' AND id != " . self::$user->id);

			DB::select(TABLE_USERS, 'id', $condition, null, 1);

			if (!DB::last()->status) return self::ERROR_EDIT_PERSONAL;

			if (DB::last()->rows === 1) return self::ERROR_EMAIL_DUPLICATE;

			# Update user

			$data = array();

			$data['email']              = $email;
			$data['first_name']         = $first_name;
			$data['last_name']          = $last_name;
			$data['sex']                = $sex;
			$data['city']               = $city;
			$data['country']            = $country;
			$data['timezone']           = $timezone;

			if (!self::$user->edit($data)) return self::ERROR_EDIT_PERSONAL;

			# ------------------------

			return true;
		}

		# Edit password data

		public static function editPassword($post) {

			if (0 === self::$user->id) return false;

			# Declare variables

			$password = null; $password_new = null; $password_retype = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($password = self::$user->validatePassword($password))) return self::ERROR_PASSWORD_INVALID;

			if (false === ($password_new = self::$user->validatePassword($password_new))) return self::ERROR_PASSWORD_NEW_INVALID;

			if (0 !== strcmp($password_new, $password_retype)) return self::ERROR_PASSWORD_MISMATCH;

			# Check password

			$password = String::encode(self::$user->auth_key, $password);

			if (0 !== strcmp(self::$user->password, $password)) return self::ERROR_PASSWORD_INCORRECT;

			# Encode password

			$auth_key = String::random(40); $password = String::encode($auth_key, $password_new);

			# Update user

			$data = array();

			$data['auth_key']           = $auth_key;
			$data['password']           = $password;

			if (!self::$user->edit($data)) return self::ERROR_EDIT_PASSWORD;

			# ------------------------

			return true;
		}

		# Delete session

		public static function logout() {

			if (0 === self::$user->id) return false;

			DB::delete(TABLE_USERS_SESSIONS, array('id' => self::$user->id));

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
