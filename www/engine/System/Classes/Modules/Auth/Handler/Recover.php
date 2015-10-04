<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth, System\Utils\Messages, Request;

	class Recover extends Auth\Utils\Handler {

		protected $view = 'Blocks\Auth\Recover';

		# Handle request

		public function handle() {

			# Init user by secret code

			if (false !== ($code = Auth::secret())) $this->code = $code;

			else Request::redirect((Auth::admin() ? '/admin' : '/profile') . '/reset');

			# Create form

			$this->form = new Auth\Form\Recover();

			# Submit form

			if ($this->form->submit(['System\Modules\Auth\Controller\Recover', 'process'])) {

				Request::redirect((Auth::admin() ? '/admin' : '/profile') . '/login?submitted=recover');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
