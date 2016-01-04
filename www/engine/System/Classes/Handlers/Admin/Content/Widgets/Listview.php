<?php

namespace System\Handlers\Admin\Content\Widgets {

	use System, System\Modules, Language;

	class Listview extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_WIDGETS');

			return (new Modules\Entitizer\Listview\Widgets())->handle();
		}
	}
}