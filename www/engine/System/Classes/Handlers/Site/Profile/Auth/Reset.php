<?php

namespace Handlers\Site\Profile\Auth {

	use Frames, Modules, Language;

	class Reset extends Frames\Site\Component\Profile\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_PROFILE_AUTH_RESET');

			return (new Modules\Auth\Handler\Reset())->handle();
		}
	}
}
