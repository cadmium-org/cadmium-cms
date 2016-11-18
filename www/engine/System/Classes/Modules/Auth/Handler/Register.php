<?php

namespace Modules\Auth\Handler {

	use Frames, Modules\Auth, Request;

	class Register extends Frames\Admin\Area\Auth {

		protected $title = 'TITLE_AUTH_REGISTER';

		# Handle request

		protected function handle() {

			if (!Auth::initial()) Request::redirect(INSTALL_PATH . '/admin/login');

			return (new Auth\Action\Register)->handle();
		}
	}
}
