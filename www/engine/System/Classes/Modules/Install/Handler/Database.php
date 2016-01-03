<?php

namespace System\Modules\Install\Handler {

	use System\Modules\Install, System\Utils\View, Request;

	class Database {

		private $form = null;

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Install\Database');

			# Implement form

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		public function handle() {

			# Create form

			$this->form = new Install\Form\Database();

			# Handle form

			if ($this->form->handle(new Install\Controller\Database())) {

				Request::redirect(INSTALL_PATH . '/admin/register');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
