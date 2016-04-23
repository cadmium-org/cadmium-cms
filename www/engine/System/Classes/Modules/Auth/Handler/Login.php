<?php

namespace Modules\Auth\Handler {

	use Modules\Auth, Utils\Messages, Language, Request;

	class Login extends Auth\Utils\Handler {

		protected $view = 'Blocks\Auth\Login';

		# Handle request

		public function handle() {

			# Create form

			$this->form = new Auth\Form\Login();

			# Handle form

			if ($this->form->handle(new Auth\Controller\Login())) {

				Request::redirect(INSTALL_PATH . (Auth::admin() ? '/admin' : '/profile'));
			}

			# Display success message

			if (Request::get('submitted') === 'reset') {

				Messages::set('success', Language::get('USER_SUCCESS_RESET_TEXT'), Language::get('USER_SUCCESS_RESET'));

			} else if (Request::get('submitted') === 'recover') {

				Messages::set('success', Language::get('USER_SUCCESS_RECOVER_TEXT'), Language::get('USER_SUCCESS_RECOVER'));

			} else if (Request::get('submitted') === 'register') {

				Messages::set('success', Language::get('USER_SUCCESS_REGISTER_TEXT'), Language::get('USER_SUCCESS_REGISTER'));
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
