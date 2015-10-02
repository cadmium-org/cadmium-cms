<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth as Module, System\Utils\Messages, Request;

	class Register extends Module\Utils\Handler {

		protected $view = 'Blocks\Auth\Register';

		# Handle request

		public function handle() {

			# Create form

			$this->form = new Module\Form\Register();

			# Submit form

			if ($this->form->submit(array('System\Modules\Auth\Controller\Register', 'process'))) {

				Request::redirect((Module::admin() ? '/admin' : '/profile') . '/login?submitted=register');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
