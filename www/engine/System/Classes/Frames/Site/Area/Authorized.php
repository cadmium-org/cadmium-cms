<?php

namespace Frames\Site\Area {

	use Frames, Frames\Status, Modules, Ajax, Request, Template;

	abstract class Authorized extends Frames\Site\Section {

		# Authorized area main method

		protected function area() {

			# Check auth

			if (!Modules\Auth::check() || ((false !== Request::get('logout')) && Modules\Auth::logout())) {

				Request::redirect(INSTALL_PATH . '/profile/login');
			}

			# Handle request

			if (Template::isBlock($result = $this->handle())) return $this->displayPage($result, STATUS_CODE_200);

			if (Ajax::isResponse($result)) return Ajax::output($result);

			# ------------------------

			return Status::error404();
		}
	}
}
