<?php

namespace System\Handlers\Admin\Extend {

	use System, System\Modules\Extend, Language;

	class Languages extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_EXTEND_LANGUAGES');

			$languages = new Extend\Handler\Languages();

			# ------------------------

			return $languages->handle();
		}
	}
}
