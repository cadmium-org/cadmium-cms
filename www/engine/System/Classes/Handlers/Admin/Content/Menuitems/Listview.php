<?php

namespace Handlers\Admin\Content\Menuitems {

	use Frames, Modules, Language;

	class Listview extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_MENUITEMS');

			return (new Modules\Entitizer\Listview\Menuitems())->handle();
		}
	}
}
