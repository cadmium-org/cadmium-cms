<?php

namespace System\Forms {

	use Form, Language;

	class Recover extends Form {

        # Constructor

        public function __construct($placeholder = false) {

            parent::__construct('recover');

            $placeholder = boolval($placeholder);

            # Add fields

            $this->input('password_new', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

                ($placeholder ? Language::get('USER_FIELD_PASSWORD_NEW') : ''), FORM_FIELD_REQUIRED);

			$this->input('password_retype', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

                ($placeholder ? Language::get('USER_FIELD_PASSWORD_RETYPE') : ''), FORM_FIELD_REQUIRED);
        }
    }
}
