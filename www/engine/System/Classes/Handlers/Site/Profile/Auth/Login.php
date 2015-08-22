<?php

namespace System\Handlers\Site\Profile\Auth {

	use System, System\Utils\Auth, Language;

	class Login extends System\Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			# Fill template

			$this->setTitle(Language::get('TITLE_PROFILE_AUTH_LOGIN'));

			$this->setContents(Auth\Handler\Login::handle());

			# ------------------------

			return true;
		}
	}
}
