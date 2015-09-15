<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth, System\Utils\Messages, Language, Request;

	trait Recover {

		use Auth\Utils\Handler;

		private $view = 'Blocks\Auth\Recover';

		# Handle request

		protected function handle() {

			if (Auth::admin() && Auth::initial()) Request::redirect('/admin/register');

			# Init user by secret code

			if (false !== ($code = Auth::secret())) $this->code = $code;

			else Request::redirect((Auth::admin() ? '/admin' : '/profile') . '/reset');

			# Create form

			$this->form = new Auth\Form\Recover();

			# Submit form

			if ($this->form->submit(array('System\Modules\Auth\Controller\Recover', 'process'))) {

				Request::redirect((Auth::admin() ? '/admin' : '/profile') . '/login?submitted=recover');
			}

			# Set title

			$this->title = Language::get(Auth::admin() ? 'TITLE_AUTH_RECOVER' : 'TITLE_PROFILE_AUTH_RECOVER');

			# ------------------------

			return $this->getContents();
		}
	}
}
