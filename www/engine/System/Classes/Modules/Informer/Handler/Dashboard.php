<?php

namespace System\Modules\Informer\Handler {

	use System\Modules\Config, System\Modules\Informer, System\Utils\Lister, System\Utils\Messages, System\Utils\View, Geo\Timezone, Language;

	class Dashboard {

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Informer\Dashboard');

			# Set general entries

			$contents->site_title           = Config::get('site_title');

			$contents->site_status          = Lister\Status::get(Config::get('site_status'));

			$contents->system_url           = Config::get('system_url');

			$contents->system_timezone      = Timezone::get(Config::get('system_timezone'));

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

			if (!Config::loaded()) Messages::warning(Language::get('DASHBOARD_MESSAGE_CONFIG_FILE'));

			# ------------------------

			return $this->getContents();
		}
	}
}