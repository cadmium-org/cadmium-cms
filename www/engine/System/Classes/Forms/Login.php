<?php

namespace System\Forms {

	use System\Utils\Auth, System\Utils\Messages, Form, Language, Request;

	class Login extends Form {

        # Constructor

        public function __construct($name, $admin = false) {

            parent::__construct($name);

            $admin = boolval($admin);

            # Add fields

            parent::input('name', '', FORM_INPUT_TEXT, CONFIG_USER_NAME_MAX_LENGTH,

                ($admin ? Language::get('USER_FIELD_NAME') : ''), FORM_FIELD_REQUIRED);

			parent::input('password', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

                ($admin ? Language::get('USER_FIELD_PASSWORD') : ''), FORM_FIELD_REQUIRED);
        }

        # Post form

        public function post() {

            if (false !== ($post = parent::post())) {

				if ($this->errors) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth::login($post))) Messages::error(Language::get($result));

				else return true;

			} else if (Request::get('submitted') === 'register') {

				Messages::success(Language::get('USER_SUCCESS_REGISTER_TEXT'), Language::get('USER_SUCCESS_REGISTER'));

			} else if (Request::get('submitted') === 'recover') {

				Messages::success(Language::get('USER_SUCCESS_RECOVER_TEXT'), Language::get('USER_SUCCESS_RECOVER'));
			}

            return false;
        }
    }
}
