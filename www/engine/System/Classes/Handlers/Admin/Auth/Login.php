<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Forms, System\Utils\Auth, Language, Request;

	class Login extends System\Frames\Admin\Component\Auth {

		# Handle request

		protected function handle() {

			if ($this->initial()) Request::redirect('/admin/register');

			# Fill template

			$this->setTitle(Language::get('TITLE_AUTH_LOGIN'));

			$this->setContents(Auth\Handler\Login::handle(true));

			# ------------------------

			return true;
		}
	}
}
