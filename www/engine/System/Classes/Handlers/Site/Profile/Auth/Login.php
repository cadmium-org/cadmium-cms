<?php

namespace System\Handlers\Site\Profile\Auth {

	use System, System\Modules, Language;

	class Login extends System\Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_PROFILE_AUTH_LOGIN');

			$login = new Modules\Auth\Handler\Login();

			# ------------------------

			return $login->handle();
		}
	}
}
