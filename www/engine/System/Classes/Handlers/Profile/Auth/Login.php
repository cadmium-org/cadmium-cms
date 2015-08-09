<?php

namespace System\Handlers\Profile\Auth {

	use Error, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Login extends System\Frames\Site\Handler {

		private $form = null;

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Profile/Auth/Login');

			# Set form

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create form

			$this->form = new Form('login');

			# Add form fields

			$this->form->input        ('name', '', FORM_INPUT_TEXT, CONFIG_USER_NAME_MAX_LENGTH,

			                     '', FORM_FIELD_REQUIRED);

			$this->form->input        ('password', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

			                     '', FORM_FIELD_REQUIRED);

			# Post form

			if (false !== ($post = $this->form->post())) {

				if ($this->form->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth::login($post))) Messages::error(Language::get($result));

				else Request::redirect('/profile');

			} else if (Request::get('submitted') === 'register') {

				Messages::success(Language::get('USER_SUCCESS_REGISTER_TEXT'), Language::get('USER_SUCCESS_REGISTER'));

			} else if (Request::get('submitted') === 'recover') {

				Messages::success(Language::get('USER_SUCCESS_RECOVER_TEXT'), Language::get('USER_SUCCESS_RECOVER'));
			}

			# Fill template

			$this->setTitle(Language::get('TITLE_AUTH_LOGIN'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}
