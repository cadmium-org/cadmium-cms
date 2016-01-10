<?php

namespace Handlers\Site\Profile\Auth {

	use Frames, Modules, Language;

	class Register extends Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_PROFILE_AUTH_REGISTER');

			return (new Modules\Auth\Handler\Register())->handle();
		}
	}
}
