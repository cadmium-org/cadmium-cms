<?php

namespace Handlers\Admin\System {

	use Frames, Modules, Language;

	class Information extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_INFORMATION');

			return (new Modules\Informer\Handler\Information())->handle();
		}
	}
}
