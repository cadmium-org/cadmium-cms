<?php

namespace Handlers\Admin\Install {

	use Frames, Modules, Language;

	class Check extends Frames\Admin\Component\Install {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_INSTALL_CHECK');

			return (new Modules\Install\Handler\Check())->handle();
		}
	}
}
