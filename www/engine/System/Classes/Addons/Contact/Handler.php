<?php

namespace Addons\Contact {

	use Frames, Modules\Auth, Utils\Messages, Utils\View, Language, Request;

	class Handler extends Frames\Site\Area\Common {

		protected $title = 'TITLE_CONTACT';

		private $form = null;

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Contact/Contact');

			# Implement form

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create form

			$this->form = new Form;

			# Handle form

			if ($this->form->handle(new Controller)) Request::redirect(INSTALL_PATH . '/contact?submitted');

			# Display success message

			if (false !== Request::get('submitted')) Messages::set('success', Language::get('CONTACT_SUCCESS_SEND'));

			# ------------------------

			return $this->getContents();
		}
	}
}
