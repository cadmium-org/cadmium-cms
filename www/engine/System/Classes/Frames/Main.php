<?php

namespace System\Frames {

	use System, System\Utils\Auth, System\Utils\Config, System\Utils\Extend, Arr, DB, Language, Template, Session;

	abstract class Main {

		protected $path = false, $requirements = false, $checked = false;

		private function getRequirements() {

			# Check if mysqli extension loaded

			$requirements['mysqli'] = extension_loaded('mysqli');

			# Check if mbstring extension loaded

			$requirements['mbstring'] = extension_loaded('mbstring');

			# Check if gd extension loaded

			$requirements['gd'] = extension_loaded('gd');

			# Check if simplexml extension loaded

			$requirements['simplexml'] = extension_loaded('simplexml');

			# Check if mod_rewrite enabled

			$requirements['rewrite'] = (function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules()));

			# Check if data directory is writable

			$requirements['data'] = is_writable(DIR_SYSTEM_DATA);

			# Check if uploads directory is writable

			$requirements['uploads'] = is_writable(DIR_UPLOADS);

			# ------------------------

			return $requirements;
		}

		# Constructor

		public function __construct($path = false) {

			$this->path = Arr::force($path);

			# Get requirements list

			$this->requirements = $this->getRequirements();

			# Determine checking status

			$this->checked = !in_array(false, $this->requirements);

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
