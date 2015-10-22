<?php

namespace System\Modules\Settings\Handler {

	use System\Modules\Settings, System\Utils\Messages, System\Utils\View, Language, Request;

	class General {

		private $form = null;

		# Get contents

		public function getContents() {

			$contents = View::get('Blocks\Settings\General');

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		public function handle() {

			# Create form

			$this->form = new Settings\Form\General();

			# Submit form

			if ($this->form->submit(['System\Modules\Settings\Controller\General', 'process'])) {

				Request::redirect(INSTALL_PATH . '/admin/system/settings?submitted');

			} else if (null !== Request::get('submitted')) Messages::success(Language::get('SETTINGS_SUCCESS'));

			# ------------------------

			return $this->getContents();
		}
	}
}
