<?php

namespace Modules\Profile\Handler\Auth {

	use Frames, Modules;

	class Recover extends Frames\Site\Area\Auth {

		protected $title = 'TITLE_PROFILE_AUTH_RECOVER';

		# Handle request

		protected function handle() {

			return (new Modules\Auth\Action\Recover)->handle();
		}
	}
}
