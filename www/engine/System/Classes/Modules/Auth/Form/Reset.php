<?php

namespace System\Modules\Auth\Form {

	use System\Modules\Auth, System\Utils\Form, Language;

	class Reset extends Form {

		# Constructor

		public function __construct() {

			parent::__construct('reset');

			# Add fields

			$this->addText('name', '', FORM_FIELD_TEXT, CONFIG_USER_NAME_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_NAME') : ''), 'required' => true]);

			$this->addText('captcha', '', FORM_FIELD_CAPTCHA, CONFIG_USER_CAPTCHA_MAX_LENGTH,

				['placeholder' => (Auth::admin() ? Language::get('USER_FIELD_CAPTCHA') : ''), 'required' => true]);
		}
	}
}
