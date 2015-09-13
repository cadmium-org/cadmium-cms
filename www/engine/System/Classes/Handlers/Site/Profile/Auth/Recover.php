<?php

namespace System\Handlers\Site\Profile\Auth {

	use System, System\Modules\Auth, Language;

	class Recover extends System\Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_PROFILE_AUTH_RECOVER');

			return Auth\Handler\Recover::handle();
		}
	}
}
