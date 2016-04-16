<?php

namespace Modules\Informer\Handler {

	use Modules\Informer, Modules\Settings, Utils\Range, Utils\Messages, Utils\View, Geo\Timezone, Language;

	class Dashboard {

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Informer\Dashboard');

			# Set general entries

			$contents->site_status          = Range\Status::get(Settings::get('site_status'));

			$contents->system_timezone      = Timezone::get(Settings::get('system_timezone'));

			# Set database entries

			$contents->pages_count          = Informer::countEntries(TABLE_PAGES);

			$contents->users_count          = Informer::countEntries(TABLE_USERS);

			# ------------------------

			return $contents;
		}

		# Handle request

		public function handle() {

			# Check if install file exists

			if (Informer::checkInstallFile()) Messages::set('error', Language::get('DASHBOARD_MESSAGE_INSTALL_FILE'));

			# Check if configuration file is loaded

			if (!Settings::loaded()) Messages::set('warning', Language::get('DASHBOARD_MESSAGE_CONFIG_FILE'));

			# ------------------------

			return $this->getContents();
		}
	}
}
