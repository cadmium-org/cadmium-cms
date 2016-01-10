<?php

namespace Modules\Auth\Handler {

	use Modules\Auth, Request;

	class Recover extends Auth\Utils\Handler {

		protected $view = 'Blocks\Auth\Recover';

		# Handle request

		public function handle() {

			# Init user by secret code

			if (false !== ($code = Auth::secret())) $this->code = $code;

			else Request::redirect(INSTALL_PATH . (Auth::admin() ? '/admin' : '/profile') . '/reset');

			# Create form

			$this->form = new Auth\Form\Recover();

			# Handle form

			if ($this->form->handle(new Auth\Controller\Recover())) {

				Request::redirect(INSTALL_PATH . (Auth::admin() ? '/admin' : '/profile') . '/login?submitted=recover');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
