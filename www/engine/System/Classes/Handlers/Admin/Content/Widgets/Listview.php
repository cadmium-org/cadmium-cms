<?php

namespace Handlers\Admin\Content\Widgets {

	use Frames, Modules, Language;

	class Listview extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_WIDGETS');

			return (new Modules\Entitizer\Listview\Widgets())->handle();
		}
	}
}
