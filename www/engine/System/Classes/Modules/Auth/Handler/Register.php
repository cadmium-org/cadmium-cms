<?php

namespace Modules\Auth\Handler {

	use Modules\Auth, Request;

	class Register extends Auth\Utils\Handler {

		protected $view = 'Blocks\Auth\Register';

		# Handle request

		public function handle() {

			# Create form

			$this->form = new Auth\Form\Register();

			# Handle form

			if ($this->form->handle(new Auth\Controller\Register())) {

				Request::redirect(INSTALL_PATH . (Auth::admin() ? '/admin' : '/profile') . '/login?submitted=register');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
