<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Modules, Language;

	class Register extends System\Frames\Admin\Component\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_AUTH_REGISTER');

			return Modules\Auth\Handler\Register::handle();
		}
	}
}
