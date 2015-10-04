<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth, System\Utils\Messages, Request;

	class Register extends Auth\Utils\Handler {

		protected $view = 'Blocks\Auth\Register';

		# Handle request

		public function handle() {

			# Create form

			$this->form = new Auth\Form\Register();

			# Submit form

			if ($this->form->submit(['System\Modules\Auth\Controller\Register', 'process'])) {

				Request::redirect((Auth::admin() ? '/admin' : '/profile') . '/login?submitted=register');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
