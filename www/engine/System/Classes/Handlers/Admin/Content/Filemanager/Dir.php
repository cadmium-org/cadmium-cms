<?php

namespace Handlers\Admin\Content\Filemanager {

	use Frames, Modules, Language;

	class Dir extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_FILEMANAGER_DIR');

			return (new Modules\Filemanager\Handler\Dir())->handle();
		}
	}
}
