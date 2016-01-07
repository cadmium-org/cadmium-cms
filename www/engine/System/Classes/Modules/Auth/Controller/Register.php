<?php

namespace Modules\Auth\Controller {

	use Modules\Auth, Modules\Entitizer, Utils\Security, Utils\Validate, Str;

	class Register {

		# Invoker

		public function __invoke(array $post) {

			if (Auth::check()) return true;

			# Declare variables

			$name = ''; $password = ''; $password_retype = ''; $email = ''; $captcha = '';

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Validate::userName($name))) return 'USER_ERROR_NAME_INVALID';

			if (false === ($password = Validate::userPassword($password))) return 'USER_ERROR_PASSWORD_INVALID';

			if (false === ($email = Validate::email($email))) return 'USER_ERROR_EMAIL_INVALID';

			if (0 !== strcmp($password, $password_retype)) return 'USER_ERROR_PASSWORD_MISMATCH';

			if (false === Security::checkCaptcha($captcha)) return 'USER_ERROR_CAPTCHA_INCORRECT';

			# Create user object

			$user = Entitizer::get(ENTITY_TYPE_USER);

			# Check name exists

			if (false === ($check_name = $user->check('name', $name))) return 'USER_ERROR_AUTH_REGISTER';

			if ($check_name === 1) return 'USER_ERROR_NAME_DUPLICATE';

			# Check email exists

			if (false === ($check_email = $user->check('email', $email))) return 'USER_ERROR_AUTH_REGISTER';

			if ($check_email === 1) return 'USER_ERROR_EMAIL_DUPLICATE';

			# Encode password

			$auth_key = Str::random(40); $password = Str::encode($auth_key, $password);

			# Determine rank

			$rank = (Auth::admin() ? RANK_ADMINISTRATOR : RANK_USER);

			# Create user

			$data = [];

			$data['name']               = $name;
			$data['email']              = $email;
			$data['auth_key']           = $auth_key;
			$data['password']           = $password;
			$data['rank']               = $rank;
			$data['timezone']           = CONFIG_SYSTEM_TIMEZONE_DEFAULT;
			$data['time_registered']    = REQUEST_TIME;
			$data['time_logged']        = REQUEST_TIME;

			if (!$user->create($data)) return 'USER_ERROR_AUTH_REGISTER';

			# Send mail

			Auth\Utils\Mail::register($user);

			# ------------------------

			return true;
		}
	}
}
