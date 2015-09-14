<?php

namespace System\Handlers\Admin\System\Users {

	use System, System\Modules, Language;

	class Create extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_USERS_CREATE');

			return Modules\Entitizer\Handler\User::handle(true);
		}
	}
}
