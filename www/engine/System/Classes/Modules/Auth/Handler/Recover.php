<?php

namespace Modules\Auth\Handler {

	use Frames, Modules\Auth, Request;

	class Recover extends Frames\Admin\Area\Auth {

		protected $title = 'TITLE_AUTH_RECOVER';

		# Handle request

		protected function handle() {

			if (Auth::initial()) Request::redirect(INSTALL_PATH . '/admin/register');

			return (new Auth\Action\Recover)->handle();
		}
	}
}
