<?php

namespace System\Forms {

	use System\Utils\Auth\Auth, System\Utils\Messages, Form, Language, Request;

	class Reset extends Form {

        # Constructor

        public function __construct($placeholder = false) {

            parent::__construct('reset');

            $placeholder = boolval($placeholder);

            # Add fields

            $this->input('name', '', FORM_INPUT_TEXT, CONFIG_USER_NAME_MAX_LENGTH,

                ($placeholder ? Language::get('USER_FIELD_NAME') : ''), FORM_FIELD_REQUIRED);

			$this->input('captcha', '', FORM_INPUT_CAPTCHA, CONFIG_CAPTCHA_LENGTH,

                ($placeholder ? Language::get('USER_FIELD_CAPTCHA') : ''), FORM_FIELD_REQUIRED);
        }

        # Handle form

        public function handle() {

            if (false !== ($post = $this->post())) {

				if ($this->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth::reset($post))) Messages::error(Language::get($result));

				else return true;

			} else if (null !== Request::get('submitted')) {

				Messages::success(Language::get('USER_SUCCESS_RESET_TEXT'), Language::get('USER_SUCCESS_RESET'));
			}

            return false;
        }
    }
}
