<?php

namespace Handlers\Admin\Auth {

	use Frames, Modules, Language;

	class Reset extends Frames\Admin\Component\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_AUTH_RESET');

			return (new Modules\Auth\Handler\Reset())->handle();
		}
	}
}
