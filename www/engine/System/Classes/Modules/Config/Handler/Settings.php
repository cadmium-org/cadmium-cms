<?php

namespace System\Modules\Config\Handler {

	use System\Modules\Config, System\Utils\Messages, System\Utils\View, Language, Request;

	class Settings {

		private $form = null;

		# Get contents

		public function getContents() {

			$contents = View::get('Blocks\Config\Settings');

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		public function handle() {

			# Create form

			$this->form = new Config\Form\Settings();

			# Submit form

			if ($this->form->submit(array('System\Modules\Config\Controller\Settings', 'process'))) {

				Request::redirect('/admin/system/settings?submitted');

			} else if (null !== Request::get('submitted')) Messages::success(Language::get('SETTINGS_SUCCESS'));

			# ------------------------

			return $this->getContents();
		}
	}
}
