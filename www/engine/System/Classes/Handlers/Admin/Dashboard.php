<?php

namespace System\Handlers\Admin {

	use System, System\Modules\Informer, Language;

	class Dashboard extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_DASHBOARD');

			$dashboard = new Informer\Handler\Dashboard();

			# ------------------------

			return $dashboard->handle();
		}
	}
}
