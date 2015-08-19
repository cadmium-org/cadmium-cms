<?php

namespace System\Forms\Admin\System {

	use System\Utils\Lister, Form, Geo\Timezone;

	class Settings extends Form {

        # Constructor

        public function __construct() {

            parent::__construct('settings');

            # Add fields

            $this->input(CONFIG_PARAM_SITE_TITLE, CONFIG_SITE_TITLE, FORM_INPUT_TEXT, CONFIG_SITE_TITLE_MAX_LENGTH);

			$this->select(CONFIG_PARAM_SITE_STATUS, CONFIG_SITE_STATUS, Lister\Status::range());

			$this->input(CONFIG_PARAM_SITE_DESCRIPTION, CONFIG_SITE_DESCRIPTION, FORM_INPUT_TEXTAREA, CONFIG_SITE_DESCRIPTION_MAX_LENGTH);

			$this->input(CONFIG_PARAM_SITE_KEYWORDS, CONFIG_SITE_KEYWORDS, FORM_INPUT_TEXTAREA, CONFIG_SITE_KEYWORDS_MAX_LENGTH);

			$this->input(CONFIG_PARAM_SYSTEM_URL, CONFIG_SYSTEM_URL, FORM_INPUT_TEXT, CONFIG_SYSTEM_URL_MAX_LENGTH);

			$this->select(CONFIG_PARAM_SYSTEM_TIMEZONE, CONFIG_SYSTEM_TIMEZONE, Timezone::range());

			$this->input(CONFIG_PARAM_SYSTEM_EMAIL, CONFIG_SYSTEM_EMAIL, FORM_INPUT_TEXT, CONFIG_SYSTEM_EMAIL_MAX_LENGTH);

			$this->checkbox(CONFIG_PARAM_USERS_REGISTRATION, CONFIG_USERS_REGISTRATION);
        }
    }
}
