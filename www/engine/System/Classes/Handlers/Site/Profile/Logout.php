<?php

namespace System\Handlers\Site\Profile {

	use System, System\Modules\Auth, Request;

	class Logout extends System\Frames\Site\Component\Profile {

		# Handle request

		protected function handle() {

			Auth::logout(); Request::redirect('/profile/login');
		}
	}
}
