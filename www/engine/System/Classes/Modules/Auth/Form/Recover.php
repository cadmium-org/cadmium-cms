<?php

namespace Modules\Auth\Form {

	use Modules\Auth, Utils\Form, Language;

	class Recover extends Form {

		protected $name = 'recover';

		# Constructor

		public function __construct() {

			$this->addText('password_new', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, ['required' => true]);

			$this->addText('password_retype', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, ['required' => true]);
		}
	}
}
