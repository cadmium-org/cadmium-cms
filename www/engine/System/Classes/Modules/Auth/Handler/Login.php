<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth, System\Utils\Messages, Language, Request;

	abstract class Login {

		use Auth\Utils\Handler;

		private static $view = 'Blocks\Auth\Login';

		# Handle request

		public static function handle() {

			if (Auth::admin() && Auth::initial()) Request::redirect('/admin/register');

			# Create form

			self::$form = new Auth\Form\Login();

			# Submit form

			if (self::$form->submit(array('System\Modules\Auth\Controller\Login', 'process'))) {

				Request::redirect(Auth::admin() ? '/admin' : '/profile');

			} else if (Request::get('submitted') === 'register') {

				Messages::success(Language::get('USER_SUCCESS_REGISTER_TEXT'), Language::get('USER_SUCCESS_REGISTER'));

			} else if (Request::get('submitted') === 'recover') {

				Messages::success(Language::get('USER_SUCCESS_RECOVER_TEXT'), Language::get('USER_SUCCESS_RECOVER'));
			}

			# ------------------------

			return self::getContents();
		}
	}
}
