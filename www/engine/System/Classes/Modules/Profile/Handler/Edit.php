<?php

namespace Modules\Profile\Handler {

	use Frames, Modules\Profile, Utils\Messages, Utils\View, Language, Request;

	class Edit extends Frames\Site\Area\Authorized {

		protected $_title = 'TITLE_PROFILE';

		private $form_personal = null, $form_password = null;

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Profile/Edit');

			# Implement forms

			$this->form_personal->implement($contents);

			$this->form_password->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create forms

			$this->form_personal = new Profile\Form\Personal();

			$this->form_password = new Profile\Form\Password();

			# Create controllers

			$controller_personal = new Profile\Controller\Personal();

			$controller_password = new Profile\Controller\Password();

			# Handle forms

			if ($this->form_personal->handle($controller_personal) || $this->form_password->handle($controller_password)) {

				Request::redirect(INSTALL_PATH . '/profile/edit?submitted');
			}

			# Display success message

			if (false !== Request::get('submitted')) Messages::set('success', Language::get('USER_SUCCESS_EDIT'));

			# ------------------------

			return $this->getContents();
		}
	}
}
