<?php

namespace System\Handlers\Admin\Content {

	use System, Language, Template;

	class Filemanager extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_FILEMANAGER');

			return Template::block();
		}
	}
}
