<?php

namespace Modules\Auth\Action {

	use Modules\Auth, Request;

	class Reset extends Auth\Utils\Action {

		# Handle request

		public function handle() {

			# Set view

			$this->view = (Auth::admin() ? 'Blocks/Auth/Reset' : 'Blocks/Profile/Auth/Reset');

			# Create form

			$this->form = new Auth\Form\Reset;

			# Handle form

			if ($this->form->handle(new Auth\Controller\Reset)) {

				Request::redirect(INSTALL_PATH . (Auth::admin() ? '/admin' : '/profile') . '/login?submitted=reset');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
