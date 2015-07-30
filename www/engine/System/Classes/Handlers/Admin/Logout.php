<?php

namespace System\Handlers\Admin {

	use Error, Warning, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Logout extends System\Frames\Admin\Handler {

		# Handle request

		protected function handle() {

			Auth::logout(); Request::redirect('/admin/login');

			# ------------------------

			return true;
		}
	}
}
