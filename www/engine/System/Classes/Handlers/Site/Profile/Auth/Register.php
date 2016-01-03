<?php

namespace System\Handlers\Site\Profile\Auth {

	use System, System\Modules, Language;

	class Register extends System\Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_PROFILE_AUTH_REGISTER');

			return (new Modules\Auth\Handler\Register())->handle();
		}
	}
}
