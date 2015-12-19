<?php

namespace System\Handlers\Admin\Content\Filemanager {

	use System, System\Modules, Language;

	class Listview extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_FILEMANAGER');

			return (new Modules\Filemanager\Handler\Listview())->handle();
		}
	}
}
