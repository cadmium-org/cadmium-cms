<?php

namespace Modules\Auth\Form {

	use Modules\Auth, Utils\Form, Language;

	class Reset extends Form {

		protected $name = 'reset';

		# Constructor

		public function __construct() {

			$this->addText('name', '', FORM_FIELD_TEXT, CONFIG_USER_NAME_MAX_LENGTH, ['required' => true]);

			$this->addText('captcha', '', FORM_FIELD_CAPTCHA, CONFIG_USER_CAPTCHA_MAX_LENGTH, ['required' => true]);
		}
	}
}
