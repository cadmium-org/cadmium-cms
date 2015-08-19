<?php

namespace System\Utils\Auth\Handler {

	use System\Forms, System\Utils\Auth, System\Utils\Messages, System\Utils\View, Language, Request;

	abstract class Recover {

		# Handle recover request

		public static function handle($admin = false) {

			if (false === ($code = Auth::secret($admin))) Request::redirect(($admin ? '/admin' : '/profile') . '/reset');

			$form = new Forms\Recover($admin);

			# Post form

			if (false !== ($post = $form->post())) {

				if ($form->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth\Controller::recover($post))) Messages::error(Language::get($result));

				else Request::redirect(($admin ? '/admin' : '/profile') . '/login?submitted=recover');
			}

			# Create contents block

			$contents = View::get($admin ? 'Blocks/Contents/Auth/Recover' : 'Blocks/Contents/Profile/Auth/Recover');

			$contents->code = $code;

			$form->implement($contents);

			# ------------------------

			return $contents;
		}
	}
}
