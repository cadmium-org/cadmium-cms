<?php

namespace Modules\Auth\Action {

	use Modules\Auth, Request;

	class Register extends Auth\Utils\Action {

		# Handle request

		public function handle() {

			# Set view

			$this->view = (Auth::admin() ? 'Blocks/Auth/Register' : 'Blocks/Profile/Auth/Register');

			# Create form

			$this->form = new Auth\Form\Register;

			# Handle form

			if ($this->form->handle(new Auth\Controller\Register)) {

				Request::redirect(INSTALL_PATH . (Auth::admin() ? '/admin' : '/profile') . '/login?submitted=register');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
