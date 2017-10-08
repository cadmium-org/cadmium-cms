<?php

/**
 * @package Cadmium\System\Addons\Contact
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Addons\Contact {

	use Modules\Settings, Utils\Security, Utils\Validate, Mailer;

	class Controller {

		/**
		 * Invoker
		 *
		 * @return true|string|array : true on success, otherwise an error code, or an array of type [$param_name, $error_code],
		 *         where $param_name is a name of param that has triggered the error,
		 *         and $error_code is a language phrase related to the error
		 */

		public function __invoke(array $post) {

			# Declare variables

			$name = ''; $email = ''; $message = ''; $captcha = '';

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($email = Validate::userEmail($email))) return ['email', 'CONTACT_ERROR_EMAIL_INVALID'];

			if (false === Security::checkCaptcha($captcha)) return ['captcha', 'CONTACT_ERROR_CAPTCHA_INCORRECT'];

			# Send mail

			$to = Settings::get('system_email'); $subject = (Settings::get('site_title') . ' | Contact form message');

			if (!Mailer::send($to, $name, $email, $email, $subject, $message)) return 'CONTACT_ERROR_SEND';

			# ------------------------

			return true;
		}
	}
}
