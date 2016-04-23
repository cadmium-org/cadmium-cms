<?php

namespace Modules\Settings\Handler {

	use Modules\Settings, Utils\Popup, Utils\View, Language, Request;

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

			if ($this->form->handle(new Settings\Controller\General(), true)) {

				Request::redirect(INSTALL_PATH . '/admin/system/settings?submitted');
			}

			# Display success message

			if (false !== Request::get('submitted')) Popup::set('positive', Language::get('SETTINGS_SUCCESS'));

			# ------------------------

			return $this->getContents();
		}
	}
}
