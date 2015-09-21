<?php

namespace System\Handlers\Admin\Auth {

	use System, System\Modules\Auth, Language;

	class Register extends System\Frames\Admin\Component\Auth\Initial {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_AUTH_REGISTER');

			$register = new Auth\Handler\Register();

			# ------------------------

			return $register->handle();
		}
	}
}
