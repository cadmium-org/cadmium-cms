<?php

namespace Handlers\Admin\Content\Pages {

	use Frames, Modules, Language;

	class Create extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_PAGES_CREATE');

			return (new Modules\Entitizer\Handler\Page())->handle(true);
		}
	}
}
