<?php

namespace System\Modules\Settings\Handler {

	use System\Modules\Settings, System\Utils\Messages, System\Utils\View, Language, Request;

	class General {

		private $form = null;

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Settings\General');

			# Implement form

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		public function handle() {

			# Create form

			$this->form = new Settings\Form\General();

			# Handle form

			if ($this->form->handle(new Settings\Controller\General())) {

				Request::redirect(INSTALL_PATH . '/admin/system/settings?submitted');
			}

			# Display success message

			if (false !== Request::get('submitted')) Messages::success(Language::get('SETTINGS_SUCCESS'));

			# ------------------------

			return $this->getContents();
		}
	}
}
