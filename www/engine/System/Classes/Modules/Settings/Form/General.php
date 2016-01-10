<?php

namespace Modules\Settings\Form {

	use Modules\Settings, Utils\Form, Utils\Lister, Geo\Timezone;

	class General extends Form {

		# Constructor

		public function __construct() {

			parent::__construct('settings');

			# Add fields

			$this->addText('site_title', Settings::get('site_title'), FORM_FIELD_TEXT, CONFIG_SITE_TITLE_MAX_LENGTH, ['required' => true]);

			$this->addText('site_slogan', Settings::get('site_slogan'), FORM_FIELD_TEXT, CONFIG_SITE_SLOGAN_MAX_LENGTH);

			$this->addSelect('site_status', Settings::get('site_status'), Lister\Status::list());

			$this->addText('site_description', Settings::get('site_description'), FORM_FIELD_TEXTAREA, CONFIG_SITE_DESCRIPTION_MAX_LENGTH);

			$this->addText('site_keywords', Settings::get('site_keywords'), FORM_FIELD_TEXTAREA, CONFIG_SITE_KEYWORDS_MAX_LENGTH);

			# Add system fields

			$this->addText('system_url', Settings::get('system_url'), FORM_FIELD_TEXT, CONFIG_SYSTEM_URL_MAX_LENGTH, ['required' => true]);

			$this->addText('system_email', Settings::get('system_email'), FORM_FIELD_TEXT, CONFIG_SYSTEM_EMAIL_MAX_LENGTH, ['required' => true]);

			$this->addSelect('system_timezone', Settings::get('system_timezone'), Timezone::list(), null, ['search' => true]);

			# Add other fields

			$this->addCheckbox('users_registration', Settings::get('users_registration'));
		}
	}
}
