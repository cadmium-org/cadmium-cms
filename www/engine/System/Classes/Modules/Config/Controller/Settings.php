<?php

namespace System\Modules\Config\Controller {

	use System\Modules\Config;

	abstract class Settings {

		# Process post data

		public static function process(array $post) {

			$errors = array();

			$errors['system_url']       = 'SETTINGS_ERROR_SYSTEM_URL';
			$errors['system_email']     = 'SETTINGS_ERROR_SYSTEM_EMAIL';

			# Process post data

			foreach ($post as $name => $value) {

				if (!Config::set($name, $value)) return (isset($errors[$name]) ? $errors[$name] : false);
			}

			# Save configuration

			if (!Config::save()) return 'SETTINGS_ERROR_SAVE';

			# ------------------------

			return true;
		}
	}
}
