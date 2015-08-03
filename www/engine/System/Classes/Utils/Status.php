<?php

namespace System\Utils {

	use Date, Language, Template;

	abstract class Status  {

		# Display status screen

		private static function display($name, $code) {

			Template::main('Status/' . $name);

			Template::main()->system_url = CONFIG_SYSTEM_URL;

			Template::main()->site_title = CONFIG_SITE_TITLE;

			Template::main()->copyright = Date::year();

			# ------------------------

			Template::output($code, true);
		}

		# Display 404 error

		public static function error404() {

			Template::title(Language::get('STATUS_TITLE_404'));

			self::display('404', STATUS_CODE_404);
		}

		# Display maintenance screen

		public static function maintenance() {

			Template::title(Language::get('STATUS_TITLE_MAINTENANCE'));

			self::display('Maintenance', STATUS_CODE_503);
		}

		# Display update screen

		public static function update() {

			Template::title(Language::get('STATUS_TITLE_UPDATE'));

			self::display('Update', STATUS_CODE_503);
		}
	}
}
