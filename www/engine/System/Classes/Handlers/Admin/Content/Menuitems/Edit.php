<?php

namespace Handlers\Admin\Content\Menuitems {

	use Frames, Modules, Language;

	class Edit extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_MENUITEMS_EDIT');

			return (new Modules\Entitizer\Handler\Menuitem())->handle();
		}
	}
}
