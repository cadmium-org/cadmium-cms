<?php

namespace System\Handlers\Site\Profile\Auth {

	use System, System\Forms, System\Utils\Auth, Language;

	class Recover extends System\Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			# Fill template

			$this->setTitle(Language::get('TITLE_PROFILE_AUTH_RECOVER'));

			$this->setContents(Auth\Handler\Recover::handle());

			# ------------------------

			return true;
		}
	}
}
