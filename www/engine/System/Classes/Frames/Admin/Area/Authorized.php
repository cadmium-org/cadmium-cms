<?php

namespace Frames\Admin\Area {

	use Frames, Frames\Status, Modules, Ajax, Request, Template;

	abstract class Authorized extends Frames\Admin\Section {

		protected $layout = 'Page';

		# Authorized area main method

		protected function area() {

			# Check auth

			if (!Modules\Auth::check() || ((false !== Request::get('logout')) && Modules\Auth::logout())) {

				Request::redirect(INSTALL_PATH . '/admin/login');
			}

			# Handle request

			if (Template::isBlock($result = $this->handle())) return $this->displayPage($result, STATUS_CODE_200);

			if (Ajax::isResponse($result)) return Ajax::output($result);

			# ------------------------

			return Status::error404();
		}
	}
}
