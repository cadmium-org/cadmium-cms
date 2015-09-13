<?php

namespace System\Modules\Config\Controller {

	use System\Modules\Config;

	abstract class Settings {

		# Errors

		const ERROR_SYSTEM_URL              = 'SETTINGS_ERROR_SYSTEM_URL';
		const ERROR_SYSTEM_EMAIL            = 'SETTINGS_ERROR_SYSTEM_EMAIL';

		const ERROR_SAVE                    = 'SETTINGS_ERROR_SAVE';

		# Process post data

		public static function process(array $post) {

			$errors = array();

			$errors['system_url']           = self::ERROR_SYSTEM_URL;
			$errors['system_email']         = self::ERROR_SYSTEM_EMAIL;

			# Process post data

			foreach ($post as $name => $value) {

				if (!Config::set($name, $value)) return (isset($errors[$name]) ? $errors[$name] : false);
			}

			# Save configuration

			if (!Config::save()) return self::ERROR_SAVE;

			# ------------------------

			return true;
		}
	}
}
