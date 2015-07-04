<?php

namespace System\Handlers\Admin\Content {

	use System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination, System\Utils\Utils;
	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Filemanager extends System\Frames\Admin\Handler {

		# Handle request

		protected function handle() {

			$this->setTitle(Language::get('TITLE_CONTENT_FILEMANAGER'));

			Messages::warning(Language::get('FEATURE_NOT_AVAILABLE'));

			# ------------------------

			return true;
		}
	}
}

?>
