<?php

namespace System\Handlers\Profile\Auth {

	use Error, System, System\Forms, System\Views, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Login extends System\Frames\Site\Handler {

		# Handle request

		protected function handle() {

			# Create form

			$form = new Forms\Login();

			if ($form->handle()) Request::redirect('/profile');

			# Create contents block

			$contents = new Views\Site\Blocks\Contents\Profile\Auth\Login();

			$form->implement($contents);

			# Fill template

			$this->setTitle(Language::get('TITLE_PROFILE_AUTH_LOGIN'));

			$this->setContents($contents);

			# ------------------------

			return true;
		}
	}
}
