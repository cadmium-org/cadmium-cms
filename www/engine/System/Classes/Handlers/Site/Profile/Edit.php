<?php

namespace System\Handlers\Site\Profile {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entitizer, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Edit extends System\Frames\Site\Component\Profile {

		private $form_personal = null, $form_password = null;

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Contents/Profile/Edit');

			# Implement forms

			$this->form_personal->implement($contents);

			$this->form_password->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create forms

			$this->form_personal = new Forms\Site\Profile\Edit\Personal();

			$this->form_password = new Forms\Site\Profile\Edit\Password();

			# Post forms

			if (false !== ($post_personal = $this->form_personal->post())) {

				if ($this->form_personal->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth\Edit::personal($post_personal))) Messages::error(Language::get($result));

				else Request::redirect('/profile/edit?submitted');

			} else if (false !== ($post_password = $this->form_password->post())) {

				if ($this->form_password->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth\Edit::password($post_password))) Messages::error(Language::get($result));

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
