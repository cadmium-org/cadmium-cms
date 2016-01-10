<?php

namespace Handlers\Admin\Content\Menuitems {

	use Frames, Modules, Language;

	class Create extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_MENUITEMS_CREATE');

			return (new Modules\Entitizer\Handler\Menuitem())->handle(true);
		}
	}
}
