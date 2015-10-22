<?php

namespace System\Modules\Informer\Handler {

	use System\Modules\Informer, System\Modules\Settings, System\Utils\Lister, System\Utils\Messages, System\Utils\View, Geo\Timezone, Language;

	class Dashboard {

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Informer\Dashboard');

			# Set general entries

			$contents->site_title           = Settings::get('site_title');

			$contents->site_status          = Lister\Status::get(Settings::get('site_status'));

			$contents->system_url           = Settings::get('system_url');

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

			if (Informer::checkInstallFile()) {

				$message = Language::get('DASHBOARD_MESSAGE_INSTALL_FILE');

				Messages::error(str_replace('$install_path$', INSTALL_PATH, $message));
			}

			# Check if configuration file is loaded

			if (!Settings::loaded()) {

				$message = Language::get('DASHBOARD_MESSAGE_CONFIG_FILE');

				Messages::warning(str_replace('$install_path$', INSTALL_PATH, $message));
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
