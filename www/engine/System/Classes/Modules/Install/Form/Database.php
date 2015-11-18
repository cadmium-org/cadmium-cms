<?php

namespace System\Modules\Install\Form {

	use System\Utils\Form;

	class Database extends Form {

		# Constructor

		public function __construct() {

			parent::__construct('database');

			# Add fields

			$this->input('server', 'localhost', FORM_INPUT_TEXT, CONFIG_DATABASE_SERVER_MAX_LENGTH, [ 'required' => true ]);

			$this->input('user', '', FORM_INPUT_TEXT, CONFIG_DATABASE_USER_MAX_LENGTH, [ 'required' => true ]);

			$this->input('password', '', FORM_INPUT_TEXT, CONFIG_DATABASE_PASSWORD_MAX_LENGTH);

			$this->input('name', '', FORM_INPUT_TEXT, CONFIG_DATABASE_NAME_MAX_LENGTH, [ 'required' => true ]);
		}
	}
}
