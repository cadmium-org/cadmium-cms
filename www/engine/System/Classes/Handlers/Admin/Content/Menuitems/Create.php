<?php

namespace System\Handlers\Admin\Content\Menuitems {

	use System, System\Modules, Language;

	class Create extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_MENUITEMS_CREATE');

			return Modules\Entitizer\Handler\Menuitem::handle(true);
		}
	}
}
