<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Modules\Auth, Language;

	class Recover extends System\Frames\Admin\Component\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_AUTH_RECOVER');

			return Auth\Handler\Recover::handle();
		}
	}
}
