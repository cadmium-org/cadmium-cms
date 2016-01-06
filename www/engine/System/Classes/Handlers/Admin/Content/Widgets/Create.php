<?php

namespace Handlers\Admin\Content\Widgets {

	use Frames, Modules, Language;

	class Create extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_WIDGETS_CREATE');

			return (new Modules\Entitizer\Handler\Widget())->handle(true);
		}
	}
}
