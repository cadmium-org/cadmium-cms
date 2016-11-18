<?php

namespace Modules\Profile\Handler\Auth {

	use Frames, Modules;

	class Login extends Frames\Site\Area\Auth {

		protected $title = 'TITLE_PROFILE_AUTH_LOGIN';

		# Handle request

		protected function handle() {

			return (new Modules\Auth\Action\Login)->handle();
		}
	}
}
