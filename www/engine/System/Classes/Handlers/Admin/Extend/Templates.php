<?php

namespace Handlers\Admin\Extend {

	use Frames, Modules, Language;

	class Templates extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_EXTEND_TEMPLATES');

			return (new Modules\Extend\Handler\Templates())->handle();
		}
	}
}
