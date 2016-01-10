<?php

namespace Handlers\Admin\Content\Filemanager {

	use Frames, Modules, Language;

	class File extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_FILEMANAGER_FILE');

			return (new Modules\Filemanager\Handler\File())->handle();
		}
	}
}
