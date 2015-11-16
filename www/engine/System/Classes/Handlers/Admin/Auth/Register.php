<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Modules, Language;

	class Register extends System\Frames\Admin\Component\Auth\Initial {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_AUTH_REGISTER');

			return (new Modules\Auth\Handler\Register())->handle();
		}
	}
}
