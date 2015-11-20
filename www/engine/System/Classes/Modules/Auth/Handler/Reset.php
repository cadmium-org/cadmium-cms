<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth, Request;

	class Reset extends Auth\Utils\Handler {

		protected $view = 'Blocks\Auth\Reset';

		# Handle request

		public function handle() {

			# Create form

			$this->form = new Auth\Form\Reset();

			# Submit form

			if ($this->form->submit(new Auth\Controller\Reset())) {

				Request::redirect(INSTALL_PATH . (Auth::admin() ? '/admin' : '/profile') . '/login?submitted=reset');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
