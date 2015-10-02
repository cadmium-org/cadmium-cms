<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth as Module, System\Utils\Messages, Language, Request;

	class Reset extends Module\Utils\Handler {

		protected $view = 'Blocks\Auth\Reset';

		# Handle request

		public function handle() {

			# Create form

			$this->form = new Module\Form\Reset();

			# Submit form

			if ($this->form->submit(array('System\Modules\Auth\Controller\Reset', 'process'))) {

				Request::redirect((Module::admin() ? '/admin' : '/profile') . '/reset?submitted');

			} else if (null !== Request::get('submitted')) {

				Messages::success(Language::get('USER_SUCCESS_RESET_TEXT'), Language::get('USER_SUCCESS_RESET'));
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
