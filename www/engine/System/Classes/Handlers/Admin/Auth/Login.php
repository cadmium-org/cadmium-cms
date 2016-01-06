<?php

namespace Handlers\Admin\Auth {

	use Frames, Modules, Language;

	class Login extends Frames\Admin\Component\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_AUTH_LOGIN');

			return (new Modules\Auth\Handler\Login())->handle();
		}
	}
}
