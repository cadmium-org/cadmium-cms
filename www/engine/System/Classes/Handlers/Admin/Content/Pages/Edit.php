<?php

namespace Handlers\Admin\Content\Pages {

	use Frames, Modules, Language;

	class Edit extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_PAGES_EDIT');

			return (new Modules\Entitizer\Handler\Page())->handle();
		}
	}
}
