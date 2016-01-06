<?php

namespace Handlers\Admin\Content\Pages {

	use Frames, Modules, Language;

	class Listview extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_PAGES');

			return (new Modules\Entitizer\Listview\Pages())->handle();
		}
	}
}
