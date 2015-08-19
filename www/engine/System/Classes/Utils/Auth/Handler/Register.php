<?php

namespace System\Utils\Auth\Handler {

	use System\Forms, System\Utils\Auth, System\Utils\Messages, System\Utils\View, Language, Request;

	abstract class Register {

		# Handle register request

		public static function handle($admin = false) {

			$form = new Forms\Register($admin);

			# Post form

			if (false !== ($post = $form->post())) {

				if ($form->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth\Controller::register($post))) Messages::error(Language::get($result));

				else Request::redirect(($admin ? '/admin' : '/profile') . '/login?submitted=register');
			}

			# Create contents block

			$contents = View::get($admin ? 'Blocks/Contents/Auth/Register' : 'Blocks/Contents/Profile/Auth/Register');

			$form->implement($contents);

			# ------------------------

			return $contents;
		}
	}
}
