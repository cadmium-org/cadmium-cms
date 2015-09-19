<?php

namespace System\Handlers\Admin\Content\Menuitems {

	use System, System\Modules\Entitizer, Language;

	class Listview extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_MENUITEMS');

			$menuitems = new Entitizer\Listview\Menuitems();

			# ------------------------

			return $menuitems->handle();
		}
	}
}
