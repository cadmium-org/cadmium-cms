<?php

namespace System\Handlers\Admin\Content\Filemanager {

	use System, System\Modules, Language;

	class File extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_FILEMANAGER_FILE');

			return (new Modules\Filemanager\Handler\File())->handle();
		}
	}
}
