<?php

namespace System\Handlers\Admin\Content\Pages {

	use System, System\Modules\Entitizer, Language;

	class Create extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_PAGES_CREATE');

			return Entitizer\Handler\Page::handle(true);
		}
	}
}
