<?php

namespace System\Handlers\Site\Profile\Auth {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth\Auth, System\Utils\Config;
	use System\Utils\Entity, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Login extends System\Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			# Create form

			$form = new Forms\Login();

			if ($form->handle()) Request::redirect('/profile');

			# Create contents block

			$contents = View::get('Blocks/Contents/Profile/Auth/Login');

			$form->implement($contents);

			# Fill template

			$this->setTitle(Language::get('TITLE_PROFILE_AUTH_LOGIN'));

			$this->setContents($contents);

			# ------------------------

			return true;
		}
	}
}
