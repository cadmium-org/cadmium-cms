<?php

namespace System\Modules\Auth\Form {

	use System\Modules\Auth, System\Utils\Form, Language;

	class Register extends Form {

		# Constructor

		public function __construct() {

			parent::__construct('register');

			# Add fields

			$this->input('name', '', FORM_INPUT_TEXT, CONFIG_USER_NAME_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_NAME') : ''), 'required' => true]);

			$this->input('password', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_PASSWORD') : ''), 'required' => true]);

			$this->input('password_retype', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_PASSWORD_RETYPE') : ''), 'required' => true]);

			$this->input('email', '', FORM_INPUT_TEXT, CONFIG_USER_EMAIL_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_EMAIL') : ''), 'required' => true]);

			$this->input('captcha', '', FORM_INPUT_CAPTCHA, CONFIG_USER_CAPTCHA_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_CAPTCHA') : ''), 'required' => true]);
		}
	}
}
