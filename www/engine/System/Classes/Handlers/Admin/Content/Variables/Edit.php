<?php

namespace Handlers\Admin\Content\Variables {

	use Frames, Modules, Language;

	class Edit extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_VARIABLES_EDIT');

			return (new Modules\Entitizer\Handler\Variable())->handle();
		}
	}
}
