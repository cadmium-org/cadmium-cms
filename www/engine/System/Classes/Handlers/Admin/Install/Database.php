<?php

namespace System\Handlers\Admin\Install {

	use System, System\Modules\Install, Language;

	class Database extends System\Frames\Admin\Component\Install {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_INSTALL_DATABASE');

			$database = new Install\Handler\Database();

			# ------------------------

			return $database->handle();
		}
	}
}
