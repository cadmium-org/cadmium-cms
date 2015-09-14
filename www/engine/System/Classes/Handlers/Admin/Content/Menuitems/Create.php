<?php

namespace System\Handlers\Admin\Content\Menuitems {

	use System, System\Modules\Entitizer, Language;

	class Create extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_MENUITEMS_CREATE');

			return Entitizer\Handler\Menuitem::handle(true);
		}
	}
}