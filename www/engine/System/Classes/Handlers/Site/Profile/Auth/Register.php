<?php

namespace System\Handlers\Site\Profile\Auth {

	use System, System\Utils\Auth, Language;

	class Register extends System\Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			# Fill template

			$this->setTitle(Language::get('TITLE_PROFILE_AUTH_REGISTER'));

			$this->setContents(Auth\Handler\Register::handle());

			# ------------------------

			return true;
		}
	}
}
