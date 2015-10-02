<?php

namespace System\Handlers\Admin\Content\Pages {

	use System, System\Modules, Language;

	class Listview extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_PAGES');

			$pages = new Modules\Entitizer\Listview\Pages();

			# ------------------------

			return $pages->handle();
		}
	}
}
