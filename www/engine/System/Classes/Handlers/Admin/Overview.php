<?php

namespace System\Handlers\Admin {

	use Error, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Overview extends System\Frames\Admin\Handler {

		private $pages_count = 0, $users_count = 0;

		# Get pages count

		private function getPagesCount() {

			if (!(DB::select(TABLE_PAGES, 'COUNT(id) as count') && (DB::last()->rows === 1))) return 0;

			return intabs(DB::last()->row()['count']);
		}

		# Get users count

		private function getUsersCount() {

			if (!(DB::select(TABLE_USERS, 'COUNT(id) as count') && (DB::last()->rows === 1))) return 0;

			return intabs(DB::last()->row()['count']);
		}

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Overview');

			# Set general entries

			$contents->site_title = CONFIG_SITE_TITLE;

			$contents->site_status = Lister\Status::get(CONFIG_SITE_STATUS);

			$contents->system_url = CONFIG_SYSTEM_URL;

			$contents->system_timezone = Timezone::get(CONFIG_SYSTEM_TIMEZONE);

			# Set database entries

			$contents->pages_count = $this->pages_count;

			$contents->users_count = $this->users_count;

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			$this->pages_count = $this->getPagesCount();

			$this->users_count = $this->getUsersCount();

			# Fill template

			$this->setTitle(Language::get('TITLE_OVERVIEW'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}
