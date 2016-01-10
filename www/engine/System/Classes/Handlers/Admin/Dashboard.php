<?php

namespace Handlers\Admin {

	use Frames, Modules, Language;

	class Dashboard extends Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_DASHBOARD');

			return (new Modules\Informer\Handler\Dashboard())->handle();
		}
	}
}
