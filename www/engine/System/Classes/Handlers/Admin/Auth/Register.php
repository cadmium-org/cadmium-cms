<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination, System\Utils\Utils;
	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Register extends System\Frames\Admin\Handler {

		private $form = false;

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Auth/Register');

			# Set form

			foreach ($this->form->fields() as $name => $field) $contents->block(('field_' . $name), $field);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create form

			$this->form = new Form('register'); $fieldset = $this->form->fieldset();

			# Add form fields

			$fieldset->text			('name', '', CONFIG_USER_NAME_MAX_LENGTH, Language::get('USER_FIELD_NAME'));

			$fieldset->password		('password', '', CONFIG_USER_PASSWORD_MAX_LENGTH, Language::get('USER_FIELD_PASSWORD'));

			$fieldset->password		('password_retype', '', CONFIG_USER_PASSWORD_MAX_LENGTH, Language::get('USER_FIELD_PASSWORD_RETYPE'));

			$fieldset->text			('email', '', CONFIG_USER_EMAIL_MAX_LENGTH, Language::get('USER_FIELD_EMAIL'));

			$fieldset->captcha		('captcha', '', CONFIG_CAPTCHA_LENGTH, Language::get('USER_FIELD_CAPTCHA'));

			# Post form

			if (false !== ($post = $this->form->post())) {

				if (true !== ($result = Auth::register($post))) Messages::error(Language::get($result));

				else Request::redirect('/admin/login?submitted=register');
			}

			# Fill template

			$this->setTitle(Language::get('TITLE_AUTH_REGISTER'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}

?>
