<?php

namespace Handlers\Site\Profile {

	use Frames, Modules, Language;

	class Edit extends Frames\Site\Component\Profile {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_PROFILE');

			return (new Modules\Profile\Handler\Edit())->handle();
		}
	}
}
