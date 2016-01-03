<?php

namespace System\Handlers\Admin\Content\Variables {

	use System, System\Modules, Language;

	class Listview extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_VARIABLES');

			return (new Modules\Entitizer\Listview\Variables())->handle();
		}
	}
}
