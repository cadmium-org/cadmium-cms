<?php

namespace Modules\Profile\Handler\Auth {

	use Frames, Modules;

	class Reset extends Frames\Site\Area\Auth {

		protected $title = 'TITLE_PROFILE_AUTH_RESET';

		# Handle request

		protected function handle() {

			return (new Modules\Auth\Action\Reset)->handle();
		}
	}
}
