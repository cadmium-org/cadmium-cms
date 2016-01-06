<?php

namespace Handlers\Admin\Install {

	use Frames, Modules, Language;

	class Database extends Frames\Admin\Component\Install {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_INSTALL_DATABASE');

			return (new Modules\Install\Handler\Database())->handle();
		}
	}
}
