<?php

namespace System\Handlers\Admin\System\Users {

	use System, System\Modules\Entitizer, Language;

	class Create extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_USERS_CREATE');

			$user = new Entitizer\Handler\User(true);

			# ------------------------

			return $user->handle();
		}
	}
}
