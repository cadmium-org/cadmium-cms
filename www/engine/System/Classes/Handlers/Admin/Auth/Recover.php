<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Forms, System\Utils\Auth, Language, Request;

	class Recover extends System\Frames\Admin\Component\Auth {

		# Handle request

		protected function handle() {

			if ($this->initial()) Request::redirect('/admin/register');

			# Fill template

			$this->setTitle(Language::get('TITLE_AUTH_RECOVER'));

			$this->setContents(Auth\Handler\Recover::handle(true));

			# ------------------------

			return true;
		}
	}
}
