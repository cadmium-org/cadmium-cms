<?php

namespace System\Modules\Profile\Handler {

	use System\Modules\Profile, System\Utils\Messages, System\Utils\View, Language, Request;

	abstract class Edit {

        private static $form_personal = null, $form_password = null;

        # Get contents

		private static function getContents() {

			$contents = View::get('Blocks\Profile\Edit');

			# Implement forms

			self::$form_personal->implement($contents);

			self::$form_password->implement($contents);

			# ------------------------

			return $contents;
		}

        # Handle request

		public static function handle() {

			# Create forms

			self::$form_personal = new Profile\Form\Personal();

			self::$form_password = new Profile\Form\Password();

			# Submit forms

			$controller_personal = array('System\Modules\Profile\Controller\Personal', 'process');

			$controller_password = array('System\Modules\Profile\Controller\Password', 'process');

			if (self::$form_personal->submit($controller_personal) || self::$form_password->submit($controller_password)) {

				Request::redirect('/profile/edit?submitted');

			} else if (null !== Request::get('submitted')) Messages::success(Language::get('USER_SUCCESS_EDIT'));

			# ------------------------

			return self::getContents();
		}
	}
}
