<?php

namespace System\Handlers\Profile\Auth {

	use Error, System, System\Forms, System\Views, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Recover extends System\Frames\Site\Handler {

		# Handle request

		protected function handle() {

			if (false === ($code = Auth::secret())) Request::redirect('/profile/reset');

			# Create form

			$form = new Forms\Recover();

			if ($form->handle()) Request::redirect('/profile/login?submitted=recover');

			# Create contents block

			$contents = new Views\Site\Blocks\Contents\Profile\Auth\Recover($code);

			$form->implement($contents);

			# Fill template

			$this->setTitle(Language::get('TITLE_PROFILE_AUTH_RECOVER'));

			$this->setContents($contents);

			# ------------------------

			return true;
		}
	}
}
