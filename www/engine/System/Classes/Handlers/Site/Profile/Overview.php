<?php

namespace System\Handlers\Site\Profile {

	use System, System\Modules, Language;

	class Overview extends System\Frames\Site\Component\Profile {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_PROFILE');

			return (new Modules\Profile\Handler\Overview())->handle();
		}
	}
}
