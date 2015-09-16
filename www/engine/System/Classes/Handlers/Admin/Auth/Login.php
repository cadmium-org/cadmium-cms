<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Modules\Auth, Language;

	class Login extends System\Frames\Admin\Component\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_AUTH_LOGIN');

			$login = new Auth\Handler\Login();

			# ------------------------

			return $login->handle();
		}
	}
}
