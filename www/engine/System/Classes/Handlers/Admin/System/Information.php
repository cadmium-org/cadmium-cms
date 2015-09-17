<?php

namespace System\Handlers\Admin\System {

	use System, System\Modules\Informer, Language;

	class Information extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_SYSTEM_INFORMATION');

			$information = new Informer\Handler\Information();

			# ------------------------

			return $information->handle();
		}
	}
}
