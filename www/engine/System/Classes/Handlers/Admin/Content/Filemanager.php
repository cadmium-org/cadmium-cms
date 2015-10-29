<?php

namespace System\Handlers\Admin\Content {

	use System, System\Modules, Language;

	class Filemanager extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_FILEMANAGER');

			$filemanager = new Modules\Filemanager\Handler\Uploads();

			# ------------------------

			return $filemanager->handle();
		}
	}
}
