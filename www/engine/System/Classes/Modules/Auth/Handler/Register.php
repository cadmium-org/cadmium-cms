<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth, System\Utils\Messages, Request;

	abstract class Register {

		use Auth\Utils\Handler;

		private static $view = 'Blocks\Auth\Register';

		# Handle request

		public static function handle() {

			if (Auth::admin() && !Auth::initial()) Request::redirect('/admin/login');

			# Create form

			self::$form = new Auth\Form\Register();

			# Submit form

			if (self::$form->submit(array('System\Modules\Auth\Controller\Register', 'process'))) {

				Request::redirect((Auth::admin() ? '/admin' : '/profile') . '/login?submitted=register');
			}

			# ------------------------

			return self::getContents();
		}
	}
}
