<?php

namespace System\Handlers\Profile {

	use Error, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Edit extends System\Frames\Site\Handler {

		private $form_personal = null, $form_password = null;

		# Get personal form

		private function getFormPersonal() {

			$form = new Form('edit'); $fieldset = $form->fieldset();

			# Add form fields

			$fieldset->text         ('email', Auth::user()->email, CONFIG_USER_EMAIL_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$fieldset->text         ('first_name', Auth::user()->first_name, CONFIG_USER_FIRST_NAME_MAX_LENGTH);

			$fieldset->text         ('last_name', Auth::user()->last_name, CONFIG_USER_LAST_NAME_MAX_LENGTH);

			$fieldset->select       ('sex', Auth::user()->sex, Lister::sex());

			$fieldset->text         ('city', Auth::user()->city, CONFIG_USER_CITY_MAX_LENGTH);

			$fieldset->select       ('country', Auth::user()->country, Country::range(), Language::get('SELECT_COUNTRY'), FORM_FIELD_SEARCH);

			$fieldset->select       ('timezone', Auth::user()->timezone, Timezone::range(), Language::get('SELECT_TIMEZONE'), FORM_FIELD_SEARCH);

			# ------------------------

			return $form;
		}

		# Get password form

		private function getFormPassword() {

			$form = new Form('edit'); $fieldset = $form->fieldset();

			# Add form fields

			$fieldset->password     ('password', '', CONFIG_USER_PASSWORD_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$fieldset->password     ('password_new', '', CONFIG_USER_PASSWORD_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$fieldset->password     ('password_retype', '', CONFIG_USER_PASSWORD_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			# ------------------------

			return $form;
		}

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Profile/Edit');

			# Set forms

			foreach ($this->form_personal->fields() as $name => $block) $contents->block(('field_' . $name), $block);

			foreach ($this->form_password->fields() as $name => $block) $contents->block(('field_' . $name), $block);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create forms

			$this->form_personal = $this->getFormPersonal();

			$this->form_password = $this->getFormPassword();

			# Post forms

			if (false !== ($post_personal = $this->form_personal->post())) {

				if ($this->form_personal->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth::editPersonal($post_personal))) Messages::error(Language::get($result));

				else Request::redirect('/profile/edit?submitted');

			} else if (false !== ($post_password = $this->form_password->post())) {

				if ($this->form_password->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth::editPassword($post_password))) Messages::error(Language::get($result));

				else Request::redirect('/profile/edit?submitted');

			} else if (null !== Request::get('submitted')) Messages::success(Language::get('USER_SUCCESS_EDIT'));

			# Fill template

			$this->setTitle(Language::get('TITLE_PROFILE'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}
