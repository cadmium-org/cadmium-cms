<?php

namespace Handlers\Admin\Content\Filemanager {

	use Frames, Modules, Language;

	class Listview extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_FILEMANAGER');

			return (new Modules\Filemanager\Handler\Listview())->handle();
		}
	}
}
