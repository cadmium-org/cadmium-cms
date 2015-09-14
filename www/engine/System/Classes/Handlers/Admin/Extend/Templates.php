<?php

namespace System\Handlers\Admin\Extend {

	use System, System\Modules, Language;

	class Templates extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_EXTEND_TEMPLATES');

			return Modules\Extend\Handler\Templates::handle();
		}
	}
}
