<?php

namespace System\Handlers\Site\Profile {

	use System, System\Modules, Request;

	class Logout extends System\Frames\Site\Component\Profile {

		# Handle request

		protected function handle() {

			return (new Modules\Auth\Handler\Logout())->handle();
		}
	}
}
