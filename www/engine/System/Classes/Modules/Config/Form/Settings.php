<?php

namespace System\Modules\Config\Form {

	use System\Modules\Config, System\Utils\Form, System\Utils\Lister, Geo\Timezone;

	class Settings extends Form {

        # Constructor

        public function __construct() {

            parent::__construct('settings');

            # Add fields

            $this->input('site_title', Config::get('site_title'), FORM_INPUT_TEXT, CONFIG_SITE_TITLE_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->select('site_status', Config::get('site_status'), Lister\Status::range());

			$this->input('site_description', Config::get('site_description'), FORM_INPUT_TEXTAREA, CONFIG_SITE_DESCRIPTION_MAX_LENGTH);

			$this->input('site_keywords', Config::get('site_keywords'), FORM_INPUT_TEXTAREA, CONFIG_SITE_KEYWORDS_MAX_LENGTH);

			$this->input('system_url', Config::get('system_url'), FORM_INPUT_TEXT, CONFIG_SYSTEM_URL_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('system_email', Config::get('system_email'), FORM_INPUT_TEXT, CONFIG_SYSTEM_EMAIL_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->select('system_timezone', Config::get('system_timezone'), Timezone::range(), null, FORM_FIELD_SEARCH);

			$this->checkbox('users_registration', Config::get('users_registration'));
        }
    }
}
