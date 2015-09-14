<?php

namespace System\Handlers\Admin\System {

	use System, System\Modules, Language;

	class Settings extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_SETTINGS');

			return Modules\Config\Handler\Settings::handle();
		}
	}
}
