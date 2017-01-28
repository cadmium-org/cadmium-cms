<?php

/**
 * @package Cadmium\System\Modules\Informer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Informer\Handler {

	use Frames, Modules\Install, Modules\Settings, Utils\Range, Utils\Messages, Utils\View, DB, Geo\Timezone, Language, Template;

	class Dashboard extends Frames\Admin\Area\Panel {

		protected $_title = 'TITLE_DASHBOARD';

		/**
		 * Get the contents block
		 */

		private function getContents() : Template\Block {

			$contents = View::get('Blocks/Informer/Dashboard');

			# Set site entries

			$contents->site_status_class    = ((Settings::get('site_status') === STATUS_ONLINE) ? 'green' : 'red');

			$contents->site_status_value    = (Range\Status::get(Settings::get('site_status')) ?? '');

			$contents->system_timezone      = (Timezone::get(Settings::get('system_timezone')) ?? '');

			# Set server entries

			$contents->os_version           = (php_uname('s') . ', ' . php_uname('v'));

			$contents->php_version          = phpversion();

			$contents->mysql_version        = DB::getVersion();

			# ------------------------

			return $contents;
		}

		/**
		 * Handle the request
		 */

		protected function handle() : Template\Block {

			# Check if server meets system requirements

			if (!Install::checkRequirements()) Messages::set('error', Language::get('DASHBOARD_MESSAGE_INSTALL_REQUIREMENTS'));

			# Check if install file exists

			if (Install::checkFile()) Messages::set('warning', Language::get('DASHBOARD_MESSAGE_INSTALL_FILE'));

			# Check if settings file is loaded

			if (!Settings::areLoaded()) Messages::set('info', Language::get('DASHBOARD_MESSAGE_SETTINGS_FILE'));

			# ------------------------

			return $this->getContents();
		}
	}
}
