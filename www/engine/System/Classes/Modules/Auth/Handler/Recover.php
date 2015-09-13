<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth, System\Utils\Messages, Request;

	abstract class Recover {

		use Auth\Utils\Handler;

		private static $view = 'Blocks\Auth\Recover';

		# Handle request

		public static function handle() {

			if (Auth::admin() && Auth::initial()) Request::redirect('/admin/register');

			# Init user by secret code

			if (false === (self::$code = Auth::secret())) Request::redirect((Auth::admin() ? '/admin' : '/profile') . '/reset');

			# Create form

			self::$form = new Auth\Form\Recover();

			# Submit form

			if (self::$form->submit(array('System\Modules\Auth\Controller\Recover', 'process'))) {

				Request::redirect((Auth::admin() ? '/admin' : '/profile') . '/login?submitted=recover');
			}

			# ------------------------

			return self::getContents();
		}
	}
}
