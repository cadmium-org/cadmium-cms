<?php

namespace Modules\Auth\Form {

	use Modules\Auth, Utils\Form, Language;

	class Login extends Form {

		protected $name = 'login';

		# Constructor

		public function __construct() {

			$this->addText('name', '', FORM_FIELD_TEXT, CONFIG_USER_NAME_MAX_LENGTH, ['required' => true]);

			$this->addText('password', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, ['required' => true]);
		}
	}
}
