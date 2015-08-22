<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Utils\Auth, Language, Request;

	class Reset extends System\Frames\Admin\Component\Auth {

		# Handle request

		protected function handle() {

			if ($this->initial()) Request::redirect('/admin/register');

			# Fill template

			$this->setTitle(Language::get('TITLE_AUTH_RESET'));

			$this->setContents(Auth\Handler\Reset::handle(true));

			# ------------------------

			return true;
		}
	}
}
