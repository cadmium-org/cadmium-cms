<?php

namespace System\Modules\Auth\Form {

	use System\Modules\Auth, System\Utils\Form, Language;

	class Register extends Form {

        # Constructor

        public function __construct() {

            parent::__construct('register');

            # Add fields

            $this->input('name', '', FORM_INPUT_TEXT, CONFIG_USER_NAME_MAX_LENGTH,

                (Auth::admin() ? Language::get('USER_FIELD_NAME') : ''), FORM_FIELD_REQUIRED);

			$this->input('password', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

                (Auth::admin() ? Language::get('USER_FIELD_PASSWORD') : ''), FORM_FIELD_REQUIRED);

			$this->input('password_retype', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

                (Auth::admin() ? Language::get('USER_FIELD_PASSWORD_RETYPE') : ''), FORM_FIELD_REQUIRED);

			$this->input('email', '', FORM_INPUT_TEXT, CONFIG_USER_EMAIL_MAX_LENGTH,

                (Auth::admin() ? Language::get('USER_FIELD_EMAIL') : ''), FORM_FIELD_REQUIRED);

			$this->input('captcha', '', FORM_INPUT_CAPTCHA, CONFIG_CAPTCHA_LENGTH,

                (Auth::admin() ? Language::get('USER_FIELD_CAPTCHA') : ''), FORM_FIELD_REQUIRED);
        }
    }
}
