<?php

namespace Modules\Auth\Handler {

	use Frames, Modules\Auth, Request;

	class Reset extends Frames\Admin\Area\Auth {

		protected $_title = 'TITLE_AUTH_RESET';

		# Handle request

		protected function handle() {

			if (Auth::initial()) Request::redirect(INSTALL_PATH . '/admin/register');

			return (new Auth\Action\Reset)->handle();
		}
	}
}
