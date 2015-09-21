<?php

namespace System\Handlers\Admin\System\Users {

	use System, System\Modules\Entitizer, Language;

	class Edit extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_USERS_EDIT');

			$user_edit = new Entitizer\Handler\User();

			# ------------------------

			return $user_edit->handle();
		}
	}
}
