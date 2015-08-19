<?php

namespace System\Forms {

	use Form, Language;

	class Login extends Form {

        # Constructor

        public function __construct($placeholder = false) {

            parent::__construct('login');

            $placeholder = boolval($placeholder);

            # Add fields

            $this->input('name', '', FORM_INPUT_TEXT, CONFIG_USER_NAME_MAX_LENGTH,

                ($placeholder ? Language::get('USER_FIELD_NAME') : ''), FORM_FIELD_REQUIRED);

			$this->input('password', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

                ($placeholder ? Language::get('USER_FIELD_PASSWORD') : ''), FORM_FIELD_REQUIRED);
        }
    }
}
