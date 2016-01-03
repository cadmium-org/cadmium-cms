<?php

namespace System\Handlers\Admin\Content\Variables {

	use System, System\Modules, Language;

	class Edit extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_VARIABLES_EDIT');

			return (new Modules\Entitizer\Handler\Variable())->handle();
		}
	}
}
