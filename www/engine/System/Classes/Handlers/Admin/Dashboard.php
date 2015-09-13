<?php

namespace System\Handlers\Admin {

	use System, System\Modules\Info, Language;

	class Dashboard extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_DASHBOARD');

			return Info\Handler\Dashboard::handle();
		}
	}
}
