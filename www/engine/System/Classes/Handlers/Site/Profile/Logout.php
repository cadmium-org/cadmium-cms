<?php

namespace System\Handlers\Site\Profile {

	use System, System\Modules, Request;

	class Logout extends System\Frames\Site\Component\Profile {

		# Handle request

		protected function handle() {

			Modules\Auth::logout(); Request::redirect('/profile/login');
		}
	}
}
