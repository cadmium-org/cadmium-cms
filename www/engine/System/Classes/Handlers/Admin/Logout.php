<?php

namespace System\Handlers\Admin {

	use System, System\Modules\Auth, Request;

	class Logout extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			Auth::logout(); Request::redirect('/admin/login');
		}
	}
}
