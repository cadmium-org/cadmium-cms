<?php

namespace System\Handlers\Admin\Install {

	use System, System\Modules\Install, Language;

	class Check extends System\Frames\Admin\Component\Install {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_INSTALL_CHECK');

			return Install\Handler\Check::handle();
		}
	}
}
