<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination, System\Utils\Utils;
	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Login extends System\Frames\Admin\Handler {

		private $form = false;

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Auth/Login');

			# Set form

			foreach ($this->form->fields() as $name => $field) $contents->block(('field_' . $name), $field);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create form

			$this->form = new Form('login'); $fieldset = $this->form->fieldset();

			# Add form fields

			$fieldset->text			('name', '', CONFIG_USER_NAME_MAX_LENGTH, Language::get('USER_FIELD_NAME'));

			$fieldset->password		('password', '', CONFIG_USER_PASSWORD_MAX_LENGTH, Language::get('USER_FIELD_PASSWORD'));

			# Post form

			if (false !== ($post = $this->form->post())) {

				if (true !== ($result = Auth::login($post))) Messages::error(Language::get($result));

				else Request::redirect('/admin');

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

?>
