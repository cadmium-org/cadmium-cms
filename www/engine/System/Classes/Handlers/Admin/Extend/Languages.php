<?php

namespace Handlers\Admin\Extend {

	use Frames, Modules, Language;

	class Languages extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_EXTEND_LANGUAGES');

			return (new Modules\Extend\Handler\Languages())->handle();
		}
	}
}
