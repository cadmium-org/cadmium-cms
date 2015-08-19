<?php

namespace System\Utils\Auth\Handler {

	use System\Forms, System\Utils\Auth, System\Utils\Messages, System\Utils\View, Language, Request;

	abstract class Reset {

		# Handle reset request

		public static function handle($admin = false) {

			$form = new Forms\Reset($admin);

			# Post form

			if (false !== ($post = $form->post())) {

				if ($form->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = Auth\Controller::reset($post))) Messages::error(Language::get($result));

				else Request::redirect(($admin ? '/admin' : '/profile') . '/reset?submitted');

			} else if (null !== Request::get('submitted')) {

				Messages::success(Language::get('USER_SUCCESS_RESET_TEXT'), Language::get('USER_SUCCESS_RESET'));
			}

			# Create contents block

			$contents = View::get($admin ? 'Blocks/Contents/Auth/Reset' : 'Blocks/Contents/Profile/Auth/Reset');

			$form->implement($contents);

			# ------------------------

			return $contents;
		}
	}
}
