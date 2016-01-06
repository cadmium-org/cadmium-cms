<?php

namespace Handlers\Admin\Content\Variables {

	use Frames, Modules, Language;

	class Listview extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_VARIABLES');

			return (new Modules\Entitizer\Listview\Variables())->handle();
		}
	}
}
