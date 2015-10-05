<?php

namespace System\Modules\Profile\Form {

	use System\Utils\Form;

	class Password extends Form {

		# Constructor

		public function __construct() {

			parent::__construct('edit');

			# Add fields

			$this->input('password', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('password_new', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('password_retype', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, '', FORM_FIELD_REQUIRED);
		}
	}
}
