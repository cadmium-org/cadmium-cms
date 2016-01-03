<?php

namespace System\Handlers\Admin\Content\Variables {

	use System, System\Modules, Language;

	class Create extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_VARIABLES_CREATE');

			return (new Modules\Entitizer\Handler\Variable())->handle(true);
		}
	}
}
