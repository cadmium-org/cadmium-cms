<?php

namespace Modules\Auth\Form {

	use Modules\Auth, Utils\Form, Language;

	class Recover extends Form {

		# Constructor

		public function __construct() {

			parent::__construct('recover');

			# Add fields

			$this->addText('password_new', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_PASSWORD_NEW') : ''), 'required' => true]);

			$this->addText('password_retype', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_PASSWORD_RETYPE') : ''), 'required' => true]);
		}
	}
}
