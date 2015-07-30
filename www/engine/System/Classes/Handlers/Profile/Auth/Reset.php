<?php

namespace System\Handlers\Profile\Auth {

	use Error, Warning, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Reset extends System\Frames\Site\Handler {

		private $form = false;

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Profile/Auth/Reset');

			# Set form

			foreach ($this->form->fields() as $name => $field) $contents->block(('field_' . $name), $field);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create form

			$this->form = new Form('reset'); $fieldset = $this->form->fieldset();

			# Add form fields

			$fieldset->text			('name', false, CONFIG_USER_NAME_MAX_LENGTH, false, FORM_FIELD_REQUIRED);

			$fieldset->captcha		('captcha', false, CONFIG_CAPTCHA_LENGTH, false, FORM_FIELD_REQUIRED);

			# Post form

			if (false !== ($post = $this->form->post())) {

				if ($this->form->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth::reset($post))) Messages::error(Language::get($result));

				else Request::redirect('/profile/reset?submitted');

			} else if (null !== Request::get('submitted')) {

				Messages::success(Language::get('USER_SUCCESS_RESET_TEXT'), Language::get('USER_SUCCESS_RESET'));
			}

			# Fill template

			$this->setTitle(Language::get('TITLE_AUTH_RESET'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}
