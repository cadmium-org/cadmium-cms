<?php

namespace Handlers\Admin\System {

	use Frames, Modules, Language;

	class Settings extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_SETTINGS');

			return (new Modules\Settings\Handler\General())->handle();
		}
	}
}
