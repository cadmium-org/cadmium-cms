<?php

namespace System\Frames {

	use System\Utils\Auth, System\Utils\Config, System\Utils\Extend, System\Utils\Requirements;
	use Arr, Language, Template, Session;

	abstract class Main {

		protected $path = false;

		# Constructor

		public function __construct($path = false) {

			$this->path = Arr::force($path);

			# Init configuration

			Config::init();

			# Start session

			Session::start(CONFIG_SESSION_NAME, CONFIG_SESSION_LIFETIME);

			# Process admin section

			if ($this instanceof Admin\Handler) {

				Auth::init(true);

				Extend\Languages::load(SECTION_ADMIN, CONFIG_ADMIN_LANGUAGE, CONFIG_ADMIN_LANGUAGE_DEFAULT, true);

				Extend\Templates::load(SECTION_ADMIN, CONFIG_ADMIN_TEMPLATE, CONFIG_ADMIN_TEMPLATE_DEFAULT, true);

				Language::phrases('Admin', 'Ajax', 'Common', 'Install', 'Lister', 'Mail', 'Menuitem', 'Page', 'User');
			}

			# Process site section

			if ($this instanceof Site\Handler) {

				Auth::init();

				Extend\Languages::load(SECTION_SITE, CONFIG_SITE_LANGUAGE, CONFIG_SITE_LANGUAGE_DEFAULT);

				Extend\Templates::load(SECTION_SITE, CONFIG_SITE_TEMPLATE, CONFIG_SITE_TEMPLATE_DEFAULT);

				Language::phrases('Common', 'Lister', 'Mail', 'Site', 'User');
			}

			# Set template language

			Template::language(Extend\Languages::data('iso'));

			# Set timezone

			if (false !== ($timezone = Auth::user()->timezone())) date_default_timezone_set($timezone);

			else if (false !== CONFIG_SYSTEM_TIMEZONE) date_default_timezone_set(CONFIG_SYSTEM_TIMEZONE);

			# ------------------------

			return $this->main();
		}
	}
}

?>
