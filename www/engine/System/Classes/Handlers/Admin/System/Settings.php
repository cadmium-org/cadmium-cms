<?php

namespace System\Handlers\Admin\System {

	use System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination, System\Utils\Utils;
	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Settings extends System\Frames\Admin\Handler {

		private $form = false;

		# Save configuration

		private function setData($data) {

			foreach ($data as $field) if (false === Config::set($field->name(), $field->value())) {

				$field->error(); Messages::error(Language::get('SETTINGS_ERROR_PARAM'));
			}

			return ((false === Messages::error()) && (true === Config::save()));
		}

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/System/Settings');

			# Set form

			foreach ($this->form->fields() as $name => $field) $contents->block(('field_' . $name), $field);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create form

			$this->form = new Form('settings'); $fieldset = $this->form->fieldset();

			# Add form fields

			$fieldset->text			(CONFIG_PARAM_SITE_TITLE, CONFIG_SITE_TITLE, CONFIG_SITE_TITLE_MAX_LENGTH);

			$fieldset->select		(CONFIG_PARAM_SITE_STATUS, CONFIG_SITE_STATUS, Lister::status());

			$fieldset->textarea		(CONFIG_PARAM_SITE_DESCRIPTION, CONFIG_SITE_DESCRIPTION, CONFIG_SITE_DESCRIPTION_MAX_LENGTH);

			$fieldset->textarea		(CONFIG_PARAM_SITE_KEYWORDS, CONFIG_SITE_KEYWORDS, CONFIG_SITE_KEYWORDS_MAX_LENGTH);

			$fieldset->text			(CONFIG_PARAM_ADMIN_EMAIL, CONFIG_ADMIN_EMAIL, CONFIG_ADMIN_EMAIL_MAX_LENGTH);

			$fieldset->select		(CONFIG_PARAM_SYSTEM_TIMEZONE, CONFIG_SYSTEM_TIMEZONE, Timezone::range(), false);

			$fieldset->text			(CONFIG_PARAM_SYSTEM_URL, CONFIG_SYSTEM_URL, CONFIG_SYSTEM_URL_MAX_LENGTH);

			$fieldset->checkbox		(CONFIG_PARAM_USERS_REGISTRATION, CONFIG_USERS_REGISTRATION);

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

?>
