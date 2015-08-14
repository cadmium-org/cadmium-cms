<?php

namespace System\Handlers\Profile {

	use Error, System, System\Forms, System\Views, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entity, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Edit extends System\Frames\Site\Handler {

		private $form_personal = null, $form_password = null;

		# Get personal form

		private function getFormPersonal() {

			$form = new Form('edit');

			# Add form fields

			$form->input        ('email', Auth::user()->email, FORM_INPUT_TEXT, CONFIG_USER_EMAIL_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$form->input        ('first_name', Auth::user()->first_name, FORM_INPUT_TEXT, CONFIG_USER_FIRST_NAME_MAX_LENGTH);

			$form->input        ('last_name', Auth::user()->last_name, FORM_INPUT_TEXT, CONFIG_USER_LAST_NAME_MAX_LENGTH);

			$form->select       ('sex', Auth::user()->sex, Lister\Sex::range());

			$form->input        ('city', Auth::user()->city, FORM_INPUT_TEXT, CONFIG_USER_CITY_MAX_LENGTH);

			$form->select       ('country', Auth::user()->country, Country::range(), Language::get('SELECT_COUNTRY'), FORM_FIELD_SEARCH);

			$form->select       ('timezone', Auth::user()->timezone, Timezone::range(), Language::get('SELECT_TIMEZONE'), FORM_FIELD_SEARCH);

			# ------------------------

			return $form;
		}

		# Get password form

		private function getFormPassword() {

			$form = new Form('edit');

			# Add form fields

			$form->input        ('password', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$form->input        ('password_new', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$form->input        ('password_retype', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			# ------------------------

			return $form;
		}

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Profile/Edit');

			# Set forms

			$this->form_personal->implement($contents);

			$this->form_password->implement($contents);

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
