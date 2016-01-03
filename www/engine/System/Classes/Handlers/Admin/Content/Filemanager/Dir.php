<?php

namespace System\Handlers\Admin\Content\Filemanager {

	use System, System\Modules, Language;

	class Dir extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_FILEMANAGER_DIR');

			return (new Modules\Filemanager\Handler\Dir())->handle();
		}
	}
}
