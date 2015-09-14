<?php

namespace System\Handlers\Admin\Content\Menuitems {

	use System, System\Modules, Language;

	class Listview extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_MENUITEMS');

			return Modules\Entitizer\Listview\Menuitems::handle();
		}
	}
}
