<?php

namespace System\Handlers\Admin\System {

	use Error, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Settings extends System\Frames\Admin\Handler {

		private $form = null;

		# Save configuration

		private function setData($data) {

			foreach ($data as $name => $value) if (false === Config::set($name, $value)) {

				Messages::error(Language::get('SETTINGS_ERROR_PARAM'));
			}

			return ((null === Messages::error()) && (true === Config::save()));
		}

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/System/Settings');

			# Set form

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create form

			$this->form = new Form('settings');

			# Add form fields

			$this->form->input        (CONFIG_PARAM_SITE_TITLE, CONFIG_SITE_TITLE, FORM_INPUT_TEXT, CONFIG_SITE_TITLE_MAX_LENGTH);

			$this->form->select       (CONFIG_PARAM_SITE_STATUS, CONFIG_SITE_STATUS, Lister\Status::range());

			$this->form->input        (CONFIG_PARAM_SITE_DESCRIPTION, CONFIG_SITE_DESCRIPTION, FORM_INPUT_TEXTAREA, CONFIG_SITE_DESCRIPTION_MAX_LENGTH);

			$this->form->input        (CONFIG_PARAM_SITE_KEYWORDS, CONFIG_SITE_KEYWORDS, FORM_INPUT_TEXTAREA, CONFIG_SITE_KEYWORDS_MAX_LENGTH);

			$this->form->input        (CONFIG_PARAM_SYSTEM_URL, CONFIG_SYSTEM_URL, FORM_INPUT_TEXT, CONFIG_SYSTEM_URL_MAX_LENGTH);

			$this->form->select       (CONFIG_PARAM_SYSTEM_TIMEZONE, CONFIG_SYSTEM_TIMEZONE, Timezone::range());

			$this->form->input        (CONFIG_PARAM_SYSTEM_EMAIL, CONFIG_SYSTEM_EMAIL, FORM_INPUT_TEXT, CONFIG_SYSTEM_EMAIL_MAX_LENGTH);

			$this->form->checkbox     (CONFIG_PARAM_USERS_REGISTRATION, CONFIG_USERS_REGISTRATION);

			# Post form

			if (false !== ($post = $this->form->post())) {

				if (false === $this->setData($post)) Messages::error(Language::get('SETTINGS_ERROR_SAVE'));

				else Request::redirect('/admin/system/settings?submitted');

			} else if (null !== Request::get('submitted')) Messages::success(Language::get('SETTINGS_SUCCESS'));

			# Fill template

			$this->setTitle(Language::get('TITLE_SYSTEM_SETTINGS'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}
