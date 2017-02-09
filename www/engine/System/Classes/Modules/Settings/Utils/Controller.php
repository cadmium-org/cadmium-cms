<?php

/**
 * @package Cadmium\System\Modules\Settings
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Settings\Utils {

	use Modules\Settings;

	abstract class Controller {

		/**
		 * Invoker
		 *
		 * @return true|string|array : true on success, otherwise an error code, or an array of type [$param_name, $error_code],
		 *         where $param_name is a name of param that has triggered the error,
		 *         and $error_code is a language phrase related to the error
		 */

		public function __invoke(array $post) {

			# Define errors list

			$errors = [];

			$errors['system_url']       = 'SETTINGS_ERROR_SYSTEM_URL';
			$errors['system_email']     = 'SETTINGS_ERROR_SYSTEM_EMAIL';

			# Process post data

			foreach (Settings::setArray($post) as $name => $result) {

				if (!$result) return (isset($errors[$name]) ? [$name, $errors[$name]] : false);
			}

			# Save settings

			if (!Settings::save()) return 'SETTINGS_ERROR_SAVE';

			# ------------------------

			return true;
		}
	}
}
