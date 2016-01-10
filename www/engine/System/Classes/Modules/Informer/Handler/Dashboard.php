<?php

namespace Modules\Informer\Handler {

	use Modules\Informer, Modules\Settings, Utils\Lister, Utils\Messages, Utils\View, Geo\Timezone, Language;

	class Dashboard {

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Informer\Dashboard');

			# Set general entries

			$contents->site_status          = Lister\Status::get(Settings::get('site_status'));

			$contents->system_timezone      = Timezone::get(Settings::get('system_timezone'));

			# Set database entries

			$contents->pages_count          = Informer::countPages();

			$contents->users_count          = Informer::countUsers();

			# ------------------------

			return $contents;
		}

		# Handle request

		public function handle() {

			# Check if install file exists

			if (Informer::checkInstallFile()) Messages::error(Language::get('DASHBOARD_MESSAGE_INSTALL_FILE'));

			# Check if configuration file is loaded

			if (!Settings::loaded()) Messages::warning(Language::get('DASHBOARD_MESSAGE_CONFIG_FILE'));

			# ------------------------

			return $this->getContents();
		}
	}
}
