<?php

namespace System\Modules\Install\Handler {

	use System\Modules\Install, System\Utils\Messages, System\Utils\View, Language, Request;

	abstract class Database {

		private static $form = null;

		# Get contents

		private static function getContents() {

			$contents = View::get('Blocks\Install\Database');

			# Implement form

			self::$form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		public static function handle() {

			# Create form

			self::$form = new Install\Form\Database();

			# Submit form

			if (self::$form->submit(array('System\Modules\Install\Controller\Database', 'process'))) {

				Request::redirect('/admin/register');
			}

			# ------------------------

			return self::getContents();
		}
	}
}
