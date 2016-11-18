<?php

namespace Modules\Install\Handler {

	use Frames, Modules\Install, Utils\View, Request;

	class Database extends Frames\Admin\Area\Install {

		protected $title = 'TITLE_INSTALL_DATABASE';

		private $form = null;

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Install/Database');

			# Implement form

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create form

			$this->form = new Install\Form\Database;

			# Handle form

			if ($this->form->handle(new Install\Controller\Database)) {

				Request::redirect(INSTALL_PATH . '/admin/register');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
