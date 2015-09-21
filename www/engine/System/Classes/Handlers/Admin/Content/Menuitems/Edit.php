<?php

namespace System\Handlers\Admin\Content\Menuitems {

	use System, System\Modules\Entitizer, Language;

	class Edit extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_CONTENT_MENUITEMS_EDIT');

			$menuitem_edit = new Entitizer\Handler\Menuitem();

			# ------------------------

			return $menuitem_edit->handle();
		}
	}
}
