<?php

namespace System\Handlers\Profile\Auth {

	use System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination, System\Utils\Utils;
	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Register extends System\Frames\Site\Handler {

		private $form = false;

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Profile/Auth/Register');

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

			$fieldset->text			('name', false, CONFIG_USER_NAME_MAX_LENGTH);

			$fieldset->password		('password', false, CONFIG_USER_PASSWORD_MAX_LENGTH);

			$fieldset->password		('password_retype', false, CONFIG_USER_PASSWORD_MAX_LENGTH);

			$fieldset->text			('email', false, CONFIG_USER_EMAIL_MAX_LENGTH);

			$fieldset->captcha		('captcha', false, CONFIG_CAPTCHA_LENGTH);

			# Post form

			if (false !== ($post = $this->form->post())) {

				if (true !== ($result = Auth::register($post))) Messages::error(Language::get($result));

				else Request::redirect('/profile/login?submitted=register');
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
