<?php

/**
 * @package Cadmium\System\Modules\Settings
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Settings\Form {

	use Modules\Settings, Utils\Form, Utils\Range, Geo\Timezone;

	class Common extends Form {

		protected $name = 'settings';

		/**
		 * Constructor
		 */

		public function __construct() {

			# Site title

			$this->addText('site_title', Settings::get('site_title'),

				FORM_FIELD_TEXT, CONFIG_SITE_TITLE_MAX_LENGTH, ['required' => true]);

			# Site slogan

			$this->addText('site_slogan', Settings::get('site_slogan'),

				FORM_FIELD_TEXT, CONFIG_SITE_SLOGAN_MAX_LENGTH);

			# Site status

			$this->addSelect('site_status', Settings::get('site_status'),

				Range\Status::getRange());

			# Site description

			$this->addText('site_description', Settings::get('site_description'),

				FORM_FIELD_TEXTAREA, CONFIG_SITE_DESCRIPTION_MAX_LENGTH);

			# Site keywords

			$this->addText('site_keywords', Settings::get('site_keywords'),

				FORM_FIELD_TEXTAREA, CONFIG_SITE_KEYWORDS_MAX_LENGTH);

			# System url

			$this->addText('system_url', Settings::get('system_url'),

				FORM_FIELD_TEXT, CONFIG_SYSTEM_URL_MAX_LENGTH, ['required' => true]);

			# System email

			$this->addText('system_email', Settings::get('system_email'),

				FORM_FIELD_TEXT, CONFIG_SYSTEM_EMAIL_MAX_LENGTH, ['required' => true]);

			# System timezone

			$this->addSelect('system_timezone', Settings::get('system_timezone'),

				Timezone::getRange(), null, ['search' => true]);
		}
	}
}
