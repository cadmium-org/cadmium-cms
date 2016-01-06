<?php

namespace Handlers\Site\Profile\Auth {

	use Frames, Modules, Language;

	class Login extends Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_PROFILE_AUTH_LOGIN');

			return (new Modules\Auth\Handler\Login())->handle();
		}
	}
}
