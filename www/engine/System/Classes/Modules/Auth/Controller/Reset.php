<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Controller {

	use Modules\Auth, Modules\Entitizer, Utils\Security, Utils\Validate, Str;

	class Reset {

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

			$name_email = ''; $captcha = '';

			# Extract post array

			extract($post);

			# Validate values

			if ((false === ($name = Validate::userName($name_email))) &&

				(false === ($email = Validate::userEmail($name_email)))) return ['name_email', 'USER_ERROR_NAME_INVALID'];

			if (false === Security::checkCaptcha($captcha)) return ['captcha', 'USER_ERROR_CAPTCHA_INCORRECT'];

			# Init user

			$init_by = ((false !== $name) ? 'name' : 'email');

			if ((!$this->user->init($$init_by, $init_by)) || (Auth::isAdmin() && ($this->user->rank < RANK_ADMINISTRATOR))) {

				return ['name_email', ('USER_ERROR_' . strtoupper($init_by) .'_INCORRECT')];
			}

			# Check access

			if (!Auth::isAdmin() && ($this->user->rank === RANK_GUEST)) return 'USER_ERROR_ACCESS';

			# Create secret

			$secret = Entitizer::get(TABLE_USERS_SECRETS, $this->user->id); $secret->remove();

			$code = Str::random(40); $ip = REQUEST_CLIENT_IP; $time = REQUEST_TIME;

			$data = ['id' => $this->user->id, 'code' => $code, 'ip' => $ip, 'time' => $time];

			if (!$secret->create($data)) return 'USER_ERROR_AUTH_RESET';

			# Send mail

			Auth\Utils\Mail::sendPasswordMessage($this->user, $code);

			# ------------------------

			return true;
		}
	}
}
