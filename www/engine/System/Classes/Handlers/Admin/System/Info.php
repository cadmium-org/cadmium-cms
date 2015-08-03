<?php

namespace System\Handlers\Admin\System {

	use Error, Warning, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Info extends System\Frames\Admin\Handler {

		# Get MySQL version

		private function getMySQLVersion() {

			if (!(DB::send("SELECT VERSION() as version") && DB::last()->status)) return false;

			return strval(DB::last()->row()['version']);
		}

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/System/Info');

			$contents->system_version = CADMIUM_VERSION;

			$contents->php_version = phpversion();

			$contents->mysql_version = $this->getMySQLVersion();

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Fill template

			$this->setTitle(Language::get('TITLE_SYSTEM_INFO'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}
