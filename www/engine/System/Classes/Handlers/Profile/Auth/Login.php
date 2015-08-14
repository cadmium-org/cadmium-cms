<?php

namespace System\Handlers\Profile\Auth {

	use Error, System, System\Forms, System\Views, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Login extends System\Frames\Site\Handler {

		private $form = null;

		# Get contents

		private function getContents() {

			$contents = new Views\Site\Blocks\Contents\Login();

			# Set form

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create form

			$this->form = new Forms\Login('login');

			if ($this->form->handle()) Request::redirect('/profile');

			# Fill template

			$this->setTitle(Language::get('TITLE_AUTH_LOGIN'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}
