<?php

namespace System\Handlers\Site\Profile\Auth {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entitizer, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Register extends System\Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			# Create form

			$form = new Forms\Register();

			if ($form->handle()) Request::redirect('/profile/login?submitted=register');

			# Create contents block

			$contents = View::get('Blocks/Contents/Profile/Auth/Register');

			$form->implement($contents);

			# Fill template

			$this->setTitle(Language::get('TITLE_PROFILE_AUTH_REGISTER'));

			$this->setContents($contents);

			# ------------------------

			return true;
		}
	}
}