<?php

namespace System\Modules\Install\Form {

	use System\Utils\Form;

	class Database extends Form {

        # Constructor

        public function __construct() {

            parent::__construct();

            # Add fields

			$this->input('database_server', 'localhost', FORM_INPUT_TEXT, CONFIG_DATABASE_SERVER_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('database_user', '', FORM_INPUT_TEXT, CONFIG_DATABASE_USER_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('database_password', '', FORM_INPUT_TEXT, CONFIG_DATABASE_PASSWORD_MAX_LENGTH, '');

			$this->input('database_name', '', FORM_INPUT_TEXT, CONFIG_DATABASE_NAME_MAX_LENGTH, '', FORM_FIELD_REQUIRED);
        }
    }
}
