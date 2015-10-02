<?php

namespace System\Handlers\Admin\Content\Pages {

	use System, System\Modules, Language;

	class Create extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_PAGES_CREATE');

			$page = new Modules\Entitizer\Handler\Page();

			# ------------------------

			return $page->handle(true);
		}
	}
}
