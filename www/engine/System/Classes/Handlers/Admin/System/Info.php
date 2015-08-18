<?php

namespace System\Handlers\Admin\System {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entitizer, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Info extends System\Frames\Admin\Component\System {

		# Get MySQL version

		private function getMySQLVersion() {

			if (!(DB::send("SELECT VERSION() as version") && DB::last()->status)) return false;

			return strval(DB::last()->row()['version']);
		}

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Contents/System/Info');

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
