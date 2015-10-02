<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Modules, Language;

	class Reset extends System\Frames\Admin\Component\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_AUTH_RESET');

			$reset = new Modules\Auth\Handler\Reset();

			# ------------------------

			return $reset->handle();
		}
	}
}
