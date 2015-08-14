<?php

namespace System\Handlers\Admin\Auth {

	use Error, System, System\Forms, System\Views, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Login extends System\Frames\Admin\Handler {

		# Handle request

		protected function handle() {

			# Create form

			$form = new Forms\Login(true);

			if ($form->handle()) Request::redirect('/admin');

			# Create contents block

			$contents = new Views\Admin\Blocks\Contents\Auth\Login();

			$form->implement($contents);

			# Fill template

			$this->setTitle(Language::get('TITLE_AUTH_LOGIN'));

			$this->setContents($contents);

			# ------------------------

			return true;
		}
	}
}
