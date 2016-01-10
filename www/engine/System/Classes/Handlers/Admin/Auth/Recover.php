<?php

namespace Handlers\Admin\Auth {

	use Frames, Modules, Language;

	class Recover extends Frames\Admin\Component\Auth {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_AUTH_RECOVER');

			return (new Modules\Auth\Handler\Recover())->handle();
		}
	}
}
