<?php

namespace System\Utils\Auth\Handler {

	use System\Forms, System\Utils\Auth, System\Utils\Messages, System\Utils\View, Language, Request;

	abstract class Login {

		# Handle login request

		public static function handle($admin = false) {

			$form = new Forms\Login($admin);

			# Post form

			if (false !== ($post = $form->post())) {

				if ($form->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth\Controller::login($post))) Messages::error(Language::get($result));

				else Request::redirect($admin ? '/admin' : '/profile');

			} else if (Request::get('submitted') === 'register') {

				Messages::success(Language::get('USER_SUCCESS_REGISTER_TEXT'), Language::get('USER_SUCCESS_REGISTER'));

			} else if (Request::get('submitted') === 'recover') {

				Messages::success(Language::get('USER_SUCCESS_RECOVER_TEXT'), Language::get('USER_SUCCESS_RECOVER'));
			}

			# Create contents block

			$contents = View::get($admin ? 'Blocks/Contents/Auth/Login' : 'Blocks/Contents/Profile/Auth/Login');

			$form->implement($contents);

			# ------------------------

			return $contents;
		}
	}
}
