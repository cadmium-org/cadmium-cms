<?php

namespace System\Handlers\Admin\Content\Pages {

	use System, System\Modules\Entitizer, Language;

	class Edit extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_PAGES_EDIT');

			$page_edit = new Entitizer\Handler\Page();

			# ------------------------

			return $page_edit->handle();
		}
	}
}
