<?php

namespace System\Handlers\Admin {

	use System, System\Modules, Request;

	class Logout extends System\Frames\Admin\Component\Panel {

		# Handle request

		protected function handle() {

			return (new Modules\Auth\Handler\Logout())->handle();
		}
	}
}
