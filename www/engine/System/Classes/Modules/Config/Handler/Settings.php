<?php

namespace System\Modules\Config\Handler {

	use System\Modules\Config, System\Utils\Messages, System\Utils\View, Language, Request;

	abstract class Settings {

		private static $form = null;

		# Get contents

		public static function getContents() {

			$contents = View::get('Blocks\Config\Settings');

			self::$form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		public static function handle() {

			# Create form

			self::$form = new Config\Form\Settings();

			# Submit form

			if (self::$form->submit(array('System\Modules\Config\Controller\Settings', 'process'))) {

				Request::redirect('/admin/system/settings?submitted');

			} else if (null !== Request::get('submitted')) Messages::success(Language::get('SETTINGS_SUCCESS'));

			# ------------------------

			return self::getContents();
		}
	}
}
