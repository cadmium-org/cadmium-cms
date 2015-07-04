<?php

namespace System\Frames {

	use System\Utils\Auth, System\Utils\Config, System\Utils\Extend, Arr, DB, Language, String, Session;

	abstract class Main {

		protected $path = false;

		# Constructor

		public function __construct($path = false) {

			$this->path = Arr::force($path);

			# Start session

			Session::start(CONFIG_SESSION_NAME, CONFIG_SESSION_LIFETIME);

			# Connect to DB

			DB::connect(DATABASE_SERVER, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);

			# Init configuration

			Config::init();

			# Process admin section

			if ($this instanceof Admin\Handler) {

				Auth::init(true);

				Extend\Languages::load(false, CONFIG_ADMIN_LANGUAGE, CONFIG_ADMIN_LANGUAGE_DEFAULT);

				Extend\Templates::load(SECTION_ADMIN, CONFIG_ADMIN_TEMPLATE, CONFIG_ADMIN_TEMPLATE_DEFAULT);

				Language::phrases('Admin', 'Ajax', 'Common', 'Lister', 'Mail', 'Menuitem', 'Page', 'User');
			}

			# Process site section

			if ($this instanceof Site\Handler) {

				Auth::init();

				Extend\Languages::load(false, CONFIG_SITE_LANGUAGE, CONFIG_SITE_LANGUAGE_DEFAULT);

				Extend\Templates::load(SECTION_SITE, CONFIG_SITE_TEMPLATE, CONFIG_SITE_TEMPLATE_DEFAULT);

				Language::phrases('Common', 'Lister', 'Mail', 'Site', 'User');
			}

			# Set timezone

			if (false !== ($timezone = Auth::user()->timezone())) date_default_timezone_set($timezone);

			else if (false !== CONFIG_SYSTEM_TIMEZONE) date_default_timezone_set(CONFIG_SYSTEM_TIMEZONE);

			# ------------------------

			return $this->main();
		}
	}
}

?>
