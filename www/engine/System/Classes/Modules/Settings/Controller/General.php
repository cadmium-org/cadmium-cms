<?php

namespace Modules\Settings\Controller {

	use Modules\Informer, Modules\Settings;

	class General {

		# Invoker

		public function __invoke(array $post) {

			# Check for demo mode

			if (Informer::isDemoMode()) return 'DEMO_MODE_RESTRICTION';

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
