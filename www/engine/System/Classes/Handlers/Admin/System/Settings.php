<?php

namespace System\Handlers\Admin\System {

	use System, System\Modules\Config, Language;

	class Settings extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_SETTINGS');

			$settings = new Config\Handler\Settings();

			# ------------------------

			return $settings->handle();
		}
	}
}
