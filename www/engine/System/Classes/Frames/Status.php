<?php

namespace System\Frames {

	use System\Modules\Extend, System\Modules\Config, System\Utils\View, Date, Language, Template;

	abstract class Status  {

		# Display status screen

		private static function display($view, $title, $code) {

			$status = View::get($view);

			# Set data

			$status->language = Extend\Languages::data('iso');

			$status->title = Language::get($title);

			$status->system_url = Config::get('system_url');

			$status->site_title = Config::get('site_title');

			$status->copyright = Date::year();

			# ------------------------

			Template::output($status, true, $code);
		}

		# Display 404 error

		public static function error404() {

			self::display('Main\Status\Error404', 'STATUS_TITLE_404', STATUS_CODE_404);
		}

		# Display maintenance screen

		public static function maintenance() {

			self::display('Main\Status\Maintenance', 'STATUS_TITLE_MAINTENANCE', STATUS_CODE_503);
		}

		# Display update screen

		public static function update() {

			self::display('Main\Status\Update', 'STATUS_TITLE_UPDATE', STATUS_CODE_503);
		}
	}
}
