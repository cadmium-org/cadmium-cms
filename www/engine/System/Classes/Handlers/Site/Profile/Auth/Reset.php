<?php

namespace System\Handlers\Site\Profile\Auth {

	use System, System\Utils\Auth, Language;

	class Reset extends System\Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			# Fill template

			$this->setTitle(Language::get('TITLE_PROFILE_AUTH_RESET'));

			$this->setContents(Auth\Handler\Reset::handle());

			# ------------------------

			return true;
		}
	}
}
