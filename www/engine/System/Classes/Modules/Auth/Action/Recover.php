<?php

namespace Modules\Auth\Action {

	use Modules\Auth, Request;

	class Recover extends Auth\Utils\Action {

		# Handle request

		public function handle() {

			# Init user by secret code

			if (false !== ($code = Auth::secret())) $this->code = $code;

			else Request::redirect(INSTALL_PATH . (Auth::admin() ? '/admin' : '/profile') . '/reset');

			# Set view

			$this->view = (Auth::admin() ? 'Blocks/Auth/Recover' : 'Blocks/Profile/Auth/Recover');

			# Create form

			$this->form = new Auth\Form\Recover;

			# Handle form

			if ($this->form->handle(new Auth\Controller\Recover)) {

				Request::redirect(INSTALL_PATH . (Auth::admin() ? '/admin' : '/profile') . '/login?submitted=recover');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
