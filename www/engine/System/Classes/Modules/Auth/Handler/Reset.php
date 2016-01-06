<?php

namespace Modules\Auth\Handler {

	use Modules\Auth, Request;

	class Reset extends Auth\Utils\Handler {

		protected $view = 'Blocks\Auth\Reset';

		# Handle request

		public function handle() {

			# Create form

			$this->form = new Auth\Form\Reset();

			# Handle form

			if ($this->form->handle(new Auth\Controller\Reset())) {

				Request::redirect(INSTALL_PATH . (Auth::admin() ? '/admin' : '/profile') . '/login?submitted=reset');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
