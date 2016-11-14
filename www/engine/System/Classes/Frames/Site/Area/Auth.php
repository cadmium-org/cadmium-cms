<?php

namespace Frames\Site\Area {

	use Frames, Frames\Status, Modules, Request, Template;

	abstract class Auth extends Frames\Site\Section {

		# Auth area main method

		protected function area() {

			# Check auth

			if (Modules\Auth::check()) Request::redirect(INSTALL_PATH . '/profile');

			# Handle request

			if (Template::isBlock($result = $this->handle())) return $this->displayPage($result, STATUS_CODE_401);

			# ------------------------

			return Status::error404();
		}
	}
}
