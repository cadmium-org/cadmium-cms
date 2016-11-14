<?php

namespace Modules\Profile\Handler\Auth {

	use Frames, Modules;

	class Register extends Frames\Site\Area\Auth {

		protected $title = 'TITLE_PROFILE_AUTH_REGISTER';

		# Handle request

		protected function handle() {

			return (new Modules\Auth\Action\Register)->handle();
		}
	}
}
