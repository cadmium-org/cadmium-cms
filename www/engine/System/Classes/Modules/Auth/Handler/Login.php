<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth, System\Utils\Messages, Language, Request;

	trait Login {

		use Auth\Utils\Handler;

		private $view = 'Blocks\Auth\Login';

		# Handle request

		protected function handle() {

			if (Auth::admin() && Auth::initial()) Request::redirect('/admin/register');

			# Create form

			$this->form = new Auth\Form\Login();

			# Submit form

			if ($this->form->submit(array('System\Modules\Auth\Controller\Login', 'process'))) {

				Request::redirect(Auth::admin() ? '/admin' : '/profile');

			} else if (Request::get('submitted') === 'register') {

				Messages::success(Language::get('USER_SUCCESS_REGISTER_TEXT'), Language::get('USER_SUCCESS_REGISTER'));

			} else if (Request::get('submitted') === 'recover') {

				Messages::success(Language::get('USER_SUCCESS_RECOVER_TEXT'), Language::get('USER_SUCCESS_RECOVER'));
			}

			# Set title

			$this->title = Language::get(Auth::admin() ? 'TITLE_AUTH_LOGIN' : 'TITLE_PROFILE_AUTH_LOGIN');

			# ------------------------

			return $this->getContents();
		}
	}
}
