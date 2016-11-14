<?php

namespace Addons\Contact {

	use Modules\Auth, Modules\Settings, Utils\Security, Utils\Validate, Mailer;

	class Controller {

		# Invoker

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
