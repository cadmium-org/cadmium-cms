<?php

namespace System\Modules\Install\Handler {

	use System\Modules\Install, System\Utils\Messages, System\Utils\View, Language, Request;

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

			# Submit form

			if ($this->form->submit(array('System\Modules\Install\Controller\Database', 'process'))) {

				Request::redirect('/admin/register');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
