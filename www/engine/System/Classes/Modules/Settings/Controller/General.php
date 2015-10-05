<?php

namespace System\Modules\Settings\Controller {

	use System\Modules\Settings;

	abstract class General {

		# Process post data

		public static function process(array $post) {

			$errors = [];

			$errors['system_url']       = 'SETTINGS_ERROR_SYSTEM_URL';
			$errors['system_email']     = 'SETTINGS_ERROR_SYSTEM_EMAIL';

			# Process post data

			foreach ($post as $name => $value) {

				if (!Settings::set($name, $value)) return (isset($errors[$name]) ? $errors[$name] : false);
			}

			# Save settings

			if (!Settings::save()) return 'SETTINGS_ERROR_SAVE';

			# ------------------------

			return true;
		}
	}
}
