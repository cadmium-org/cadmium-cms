<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth as Module, System\Utils\Messages, Request;

	class Recover extends Module\Utils\Handler {

		protected $view = 'Blocks\Auth\Recover';

		# Handle request

		public function handle() {

			# Init user by secret code

			if (false !== ($code = Module::secret())) $this->code = $code;

			else Request::redirect((Module::admin() ? '/admin' : '/profile') . '/reset');

			# Create form

			$this->form = new Module\Form\Recover();

			# Submit form

			if ($this->form->submit(array('System\Modules\Auth\Controller\Recover', 'process'))) {

				Request::redirect((Module::admin() ? '/admin' : '/profile') . '/login?submitted=recover');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
