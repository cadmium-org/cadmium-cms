<?php

namespace System\Handlers\Site\Profile {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth\Auth, System\Utils\Config;
	use System\Utils\Entity, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Logout extends System\Frames\Site\Component\Profile {

		# Handle request

		protected function handle() {

			Auth::logout(); Request::redirect('/profile/login');

			# ------------------------

			return true;
		}
	}
}
