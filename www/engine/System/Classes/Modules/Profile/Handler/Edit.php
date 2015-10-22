<?php

namespace System\Modules\Profile\Handler {

	use System\Modules\Profile, System\Utils\Messages, System\Utils\View, Language, Request;

	class Edit {

		private $form_personal = null, $form_password = null;

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Profile\Edit');

			# Implement forms

			$this->form_personal->implement($contents);

			$this->form_password->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		public function handle() {

			# Create forms

			$this->form_personal = new Profile\Form\Personal();

			$this->form_password = new Profile\Form\Password();

			# Submit forms

			$controller_personal = ['System\Modules\Profile\Controller\Personal', 'process'];

			$controller_password = ['System\Modules\Profile\Controller\Password', 'process'];

			if ($this->form_personal->submit($controller_personal) || $this->form_password->submit($controller_password)) {

				Request::redirect(INSTALL_PATH . '/profile/edit?submitted');

			} else if (null !== Request::get('submitted')) Messages::success(Language::get('USER_SUCCESS_EDIT'));

			# ------------------------

			return $this->getContents();
		}
	}
}
