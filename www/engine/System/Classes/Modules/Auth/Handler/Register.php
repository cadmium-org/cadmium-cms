<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth, System\Utils\Messages, Language, Request;

	trait Register {

		use Auth\Utils\Handler;

		private $view = 'Blocks\Auth\Register';

		# Handle request

		protected function handle() {

			if (Auth::admin() && !Auth::initial()) Request::redirect('/admin/login');

			# Create form

			$this->form = new Auth\Form\Register();

			# Submit form

			if ($this->form->submit(array('System\Modules\Auth\Controller\Register', 'process'))) {

				Request::redirect((Auth::admin() ? '/admin' : '/profile') . '/login?submitted=register');
			}

			# Set title

			$this->title = Language::get(Auth::admin() ? 'TITLE_AUTH_REGISTER' : 'TITLE_PROFILE_AUTH_REGISTER');

			# ------------------------

			return $this->getContents();
		}
	}
}
