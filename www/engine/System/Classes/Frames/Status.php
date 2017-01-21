<?php

/**
 * @package Cadmium\System\Frames
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Frames {

	use Modules\Extend, Date, Language, Template;

	abstract class Status extends \Utils\View {

		/**
		 * Display a status screen
		 */

		private static function display(string $view, string $title, int $status) {

			$screen = self::get($view);

			# Set data

			$screen->language = Extend\Languages::data('iso');

			$screen->title = Language::get($title);

			$screen->copyright = Date::getYear();

			# ------------------------

			Template::output($screen, $status);
		}

		/**
		 * Display the 404 error screen
		 */

		public static function displayError404() {

			self::display('Main/Status/Error404', 'STATUS_TITLE_404', STATUS_CODE_404);
		}

		/**
		 * Display the maintenance screen
		 */

		public static function displayMaintenance() {

			self::display('Main/Status/Maintenance', 'STATUS_TITLE_MAINTENANCE', STATUS_CODE_503);
		}

		/**
		 * Display the update screen
		 */

		public static function displayUpdate() {

			self::display('Main/Status/Update', 'STATUS_TITLE_UPDATE', STATUS_CODE_503);
		}
	}
}
