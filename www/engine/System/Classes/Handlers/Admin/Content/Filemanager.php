<?php

namespace System\Handlers\Admin\Content {

	use System, System\Utils\Messages, Language, Template;

	class Filemanager extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_FILEMANAGER');

			Messages::info(Language::get('FEATURE_NOT_AVAILABLE'));

			return Template::block();
		}
	}
}
