<?php

namespace System\Modules\Settings\Form {

	use System\Modules\Settings, System\Utils\Form, System\Utils\Lister, Geo\Timezone;

	class General extends Form {

		# Constructor

		public function __construct() {

			parent::__construct('settings');

			# Add fields

			$this->input('site_title', Settings::get('site_title'), FORM_INPUT_TEXT, CONFIG_SITE_TITLE_MAX_LENGTH, ['required' => true]);

			$this->input('site_slogan', Settings::get('site_slogan'), FORM_INPUT_TEXT, CONFIG_SITE_SLOGAN_MAX_LENGTH);

			$this->select('site_status', Settings::get('site_status'), Lister\Status::list());

			$this->textarea('site_description', Settings::get('site_description'), CONFIG_SITE_DESCRIPTION_MAX_LENGTH, 4);

			$this->textarea('site_keywords', Settings::get('site_keywords'), CONFIG_SITE_KEYWORDS_MAX_LENGTH, 4);

			# Add system fields

			$this->input('system_url', Settings::get('system_url'), FORM_INPUT_TEXT, CONFIG_SYSTEM_URL_MAX_LENGTH, ['required' => true]);

			$this->input('system_email', Settings::get('system_email'), FORM_INPUT_TEXT, CONFIG_SYSTEM_EMAIL_MAX_LENGTH, ['required' => true]);

			$this->select('system_timezone', Settings::get('system_timezone'), Timezone::list(), null, ['search' => true]);

			# Add other fields

			$this->checkbox('users_registration', Settings::get('users_registration'));
		}
	}
}
