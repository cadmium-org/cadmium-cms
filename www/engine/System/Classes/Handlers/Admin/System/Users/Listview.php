<?php

namespace System\Handlers\Admin\System\Users {

	use System, System\Modules, Language;

	class Listview extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_USERS');

			$users = new Modules\Entitizer\Listview\Users();

			# ------------------------

			return $users->handle();
		}
	}
}
