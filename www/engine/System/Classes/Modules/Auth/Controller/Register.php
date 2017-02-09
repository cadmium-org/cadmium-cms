<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Controller {

	use Modules\Auth, Modules\Entitizer, Utils\Security, Utils\Validate, Str;

	class Register {

		private $user = null;

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->user = Entitizer::get(TABLE_USERS);
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

			$name = ''; $password = ''; $password_retype = ''; $email = ''; $captcha = '';

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Validate::userName($name))) return ['name', 'USER_ERROR_NAME_INVALID'];

			if (false === ($password = Validate::userPassword($password))) return ['password', 'USER_ERROR_PASSWORD_INVALID'];

			if (false === ($email = Validate::userEmail($email))) return ['email', 'USER_ERROR_EMAIL_INVALID'];

			if (0 !== strcmp($password, $password_retype)) return ['password_retype', 'USER_ERROR_PASSWORD_MISMATCH'];

			if (false === Security::checkCaptcha($captcha)) return ['captcha', 'USER_ERROR_CAPTCHA_INCORRECT'];

			# Check name exists

			if (false === ($check_name = $this->user->check($name, 'name'))) return 'USER_ERROR_AUTH_REGISTER';

			if ($check_name === 1) return ['name', 'USER_ERROR_NAME_DUPLICATE'];

			# Check email exists

			if (false === ($check_email = $this->user->check($email, 'email'))) return 'USER_ERROR_AUTH_REGISTER';

			if ($check_email === 1) return ['email', 'USER_ERROR_EMAIL_DUPLICATE'];

			# Encode password

			$auth_key = Str::random(40); $password = Str::encode($auth_key, $password);

			# Determine rank

			$rank = (Auth::isAdmin() ? RANK_ADMINISTRATOR : RANK_USER);

			# Create user

			$data = [];

			$data['name']               = $name;
			$data['email']              = $email;
			$data['auth_key']           = $auth_key;
			$data['password']           = $password;
			$data['rank']               = $rank;
			$data['timezone']           = CONFIG_SYSTEM_TIMEZONE;
			$data['time_registered']    = REQUEST_TIME;
			$data['time_logged']        = REQUEST_TIME;

			if (!$this->user->create($data)) return 'USER_ERROR_AUTH_REGISTER';

			# Send mail

			Auth\Utils\Mail::sendRegistrationMessage($this->user);

			# ------------------------

			return true;
		}
	}
}
