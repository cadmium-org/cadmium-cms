<?php

namespace System\Handlers\Admin\Content\Menuitems {

	use System, System\Modules, Language;

	class Edit extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_MENUITEMS_EDIT');

			return (new Modules\Entitizer\Handler\Menuitem())->handle();
		}
	}
}
