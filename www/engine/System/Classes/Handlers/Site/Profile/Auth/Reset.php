<?php

namespace System\Handlers\Site\Profile\Auth {

	use System, System\Modules, Language;

	class Reset extends System\Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_PROFILE_AUTH_RESET');

			return (new Modules\Auth\Handler\Reset())->handle();
		}
	}
}
