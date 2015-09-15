<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth, System\Utils\Messages, Language, Request;

	trait Reset {

		use Auth\Utils\Handler;

		private $view = 'Blocks\Auth\Reset';

		# Handle request

		protected function handle() {

			if (Auth::admin() && Auth::initial()) Request::redirect('/admin/register');

			# Create form

			$this->form = new Auth\Form\Reset();

			# Submit form

			if ($this->form->submit(array('System\Modules\Auth\Controller\Reset', 'process'))) {

				Request::redirect((Auth::admin() ? '/admin' : '/profile') . '/reset?submitted');

			} else if (null !== Request::get('submitted')) {

				Messages::success(Language::get('USER_SUCCESS_RESET_TEXT'), Language::get('USER_SUCCESS_RESET'));
			}

			# Set title

			$this->title = Language::get(Auth::admin() ? 'TITLE_AUTH_RESET' : 'TITLE_PROFILE_AUTH_RESET');

			# ------------------------

			return $this->getContents();
		}
	}
}
