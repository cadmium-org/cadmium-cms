<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Modules, Language;

	class Login extends System\Frames\Admin\Component\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_AUTH_LOGIN');

			return (new Modules\Auth\Handler\Login())->handle();
		}
	}
}
