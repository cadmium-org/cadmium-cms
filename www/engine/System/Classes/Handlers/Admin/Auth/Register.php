<?php

namespace Handlers\Admin\Auth {

	use Frames, Modules, Language;

	class Register extends Frames\Admin\Component\Auth\Initial {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_AUTH_REGISTER');

			return (new Modules\Auth\Handler\Register())->handle();
		}
	}
}
