<?php

namespace Handlers\Admin\System\Users {

	use Frames, Modules, Language;

	class Listview extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_USERS');

			return (new Modules\Entitizer\Listview\Users())->handle();
		}
	}
}
