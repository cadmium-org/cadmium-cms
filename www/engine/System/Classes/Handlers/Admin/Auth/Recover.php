<?php

namespace System\Handlers\Admin\Auth {

	use Error, Warning, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Recover extends System\Frames\Admin\Handler {

		private $code = null, $form = null;

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Auth/Recover');

			# Set code

			$contents->code = $this->code;

			# Set form

			foreach ($this->form->fields() as $name => $field) $contents->block(('field_' . $name), $field);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			if (false === ($this->code = Auth::secret(true))) Request::redirect('/admin/reset');

			# Create form

			$this->form = new Form('recover'); $fieldset = $this->form->fieldset();

			# Add form fields

			$fieldset->password		('password_new', '', CONFIG_USER_PASSWORD_MAX_LENGTH, Language::get('USER_FIELD_PASSWORD_NEW'), FORM_FIELD_REQUIRED);

			$fieldset->password		('password_retype', '', CONFIG_USER_PASSWORD_MAX_LENGTH, Language::get('USER_FIELD_PASSWORD_RETYPE'), FORM_FIELD_REQUIRED);

			# Post form

			if (false !== ($post = $this->form->post())) {

				if ($this->form->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth::recover($post))) Messages::error(Language::get($result));

				else Request::redirect('/admin/login?submitted=recover');
			}

			# Fill template

			$this->setTitle(Language::get('TITLE_AUTH_RECOVER'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}
