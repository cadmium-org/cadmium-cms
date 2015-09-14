<?php

namespace System\Handlers\Admin\System\Users {

	use System, System\Modules, Language;

	class Edit extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_USERS_EDIT');

			return Modules\Entitizer\Handler\User::handle();
		}
	}
}
