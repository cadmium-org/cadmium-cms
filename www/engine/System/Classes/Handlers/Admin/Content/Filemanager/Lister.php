<?php

namespace Handlers\Admin\Content\Filemanager {

	use Frames, Modules, Language;

	class Lister extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_FILEMANAGER');

			return (new Modules\Filemanager\Handler\Lister())->handle();
		}
	}
}
