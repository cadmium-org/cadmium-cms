<?php

namespace System\Modules\Auth\Form {

	use System\Modules\Auth, System\Utils\Form, Language;

	class Login extends Form {

		# Constructor

		public function __construct() {

			parent::__construct('login');

			# Add fields

			$this->addText('name', '', FORM_FIELD_TEXT, CONFIG_USER_NAME_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_NAME') : ''), 'required' => true]);

			$this->addText('password', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_PASSWORD') : ''), 'required' => true]);
		}
	}
}
