<?php

namespace Handlers\Admin\System\Users {

	use Frames, Modules, Language;

	class Create extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_USERS_CREATE');

			return (new Modules\Entitizer\Handler\User())->handle(true);
		}
	}
}
