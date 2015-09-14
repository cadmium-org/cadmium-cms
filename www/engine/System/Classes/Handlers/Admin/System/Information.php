<?php

namespace System\Handlers\Admin\System {

	use System, System\Modules, Language;

	class Information extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_INFORMATION');

			return Modules\Info\Handler\Information::handle();
		}
	}
}
