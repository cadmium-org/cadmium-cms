<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth, System\Utils\Messages, Language, Request;

	class Reset extends Auth\Utils\Handler {

		protected $view = 'Blocks\Auth\Reset';

		# Handle request

		public function handle() {

			if (Auth::admin() && Auth::initial()) Request::redirect('/admin/register');

			# Create form

			$this->form = new Auth\Form\Reset();

			# Submit form

			if ($this->form->submit(array('System\Modules\Auth\Controller\Reset', 'process'))) {

				Request::redirect((Auth::admin() ? '/admin' : '/profile') . '/reset?submitted');

			} else if (null !== Request::get('submitted')) {

				Messages::success(Language::get('USER_SUCCESS_RESET_TEXT'), Language::get('USER_SUCCESS_RESET'));
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
