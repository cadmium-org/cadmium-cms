<?php

namespace System\Modules\Auth\Handler {

	use System\Modules\Auth, Request;

	class Logout {

		# Handle request

		public function handle() {

			# Process logout

			Auth::logout();

			# Redirect to login page

			Request::redirect(Auth::admin() ? '/admin/login' : '/profile/login');
		}
	}
}
