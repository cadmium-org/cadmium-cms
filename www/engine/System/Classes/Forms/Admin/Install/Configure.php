<?php

namespace System\Forms\Admin\Install {

	use Form, Geo\Timezone, Language;

	class Configure extends Form {

        # Constructor

        public function __construct() {

            parent::__construct();

            # Add fields

			$this->input('site_title', CONFIG_SITE_TITLE, FORM_INPUT_TEXT, CONFIG_SITE_TITLE_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('system_url', CONFIG_SYSTEM_URL, FORM_INPUT_TEXT, CONFIG_SYSTEM_URL_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->select('system_timezone', CONFIG_SYSTEM_TIMEZONE, Timezone::range(), Language::get('SELECT_TIMEZONE'), FORM_FIELD_REQUIRED);

			$this->input('system_email', CONFIG_SYSTEM_EMAIL, FORM_INPUT_TEXT, CONFIG_SYSTEM_EMAIL_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('database_server', 'localhost', FORM_INPUT_TEXT, CONFIG_DATABASE_SERVER_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('database_user', '', FORM_INPUT_TEXT, CONFIG_DATABASE_USER_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('database_password', '', FORM_INPUT_TEXT, CONFIG_DATABASE_PASSWORD_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('database_name', '', FORM_INPUT_TEXT, CONFIG_DATABASE_NAME_MAX_LENGTH, '', FORM_FIELD_REQUIRED);
        }
    }
}
