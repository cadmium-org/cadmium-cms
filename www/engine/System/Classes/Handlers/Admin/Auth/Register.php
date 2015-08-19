<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Forms, System\Utils\Auth, Language, Request;

	class Register extends System\Frames\Admin\Component\Auth {

		# Handle request

		protected function handle() {

			if (!$this->initial()) Request::redirect('/admin/login');

			# Fill template

			$this->setTitle(Language::get('TITLE_AUTH_REGISTER'));

			$this->setContents(Auth\Handler\Register::handle(true));

			# ------------------------

			return true;
		}
	}
}
