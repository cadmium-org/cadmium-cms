<?php

namespace Frames\Admin\Area {

	use Frames, Frames\Status, Modules, Request, Template;

	abstract class Auth extends Frames\Admin\Section {

		protected $layout = 'Form';

		# Auth area main method

		protected function area() {

			# Check auth

			if (Modules\Auth::check()) Request::redirect(INSTALL_PATH . '/admin');

			# Handle request

			if (Template::isBlock($result = $this->handle())) return $this->displayPage($result, STATUS_CODE_401);

			# ------------------------

			return Status::error404();
		}
	}
}
