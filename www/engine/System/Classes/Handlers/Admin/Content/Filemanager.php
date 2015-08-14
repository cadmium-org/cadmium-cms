<?php

namespace System\Handlers\Admin\Content {

	use Error, System, System\Forms, System\Views, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entity, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Filemanager extends System\Frames\Admin\Component\Content {

		# Handle request

		protected function handle() {

			$this->setTitle(Language::get('TITLE_CONTENT_FILEMANAGER'));

			Messages::warning(Language::get('FEATURE_NOT_AVAILABLE'));

			# ------------------------

			return true;
		}
	}
}
