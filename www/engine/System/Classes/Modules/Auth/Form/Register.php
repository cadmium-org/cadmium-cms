<?php

namespace Modules\Auth\Form {

	use Modules\Auth, Utils\Form, Language;

	class Register extends Form {

		# Constructor

		public function __construct() {

			parent::__construct('register');

			# Add fields

			$this->addText('name', '', FORM_FIELD_TEXT, CONFIG_USER_NAME_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_NAME') : ''), 'required' => true]);

			$this->addText('password', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_PASSWORD') : ''), 'required' => true]);

			$this->addText('password_retype', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_PASSWORD_RETYPE') : ''), 'required' => true]);

			$this->addText('email', '', FORM_FIELD_TEXT, CONFIG_USER_EMAIL_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_EMAIL') : ''), 'required' => true]);

			$this->addText('captcha', '', FORM_FIELD_CAPTCHA, CONFIG_USER_CAPTCHA_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_CAPTCHA') : ''), 'required' => true]);
		}
	}
}
