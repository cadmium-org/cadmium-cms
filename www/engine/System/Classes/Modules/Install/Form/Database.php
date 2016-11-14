<?php

namespace Modules\Install\Form {

	use Utils\Form;

	class Database extends Form {

		protected $name = 'database';

		# Constructor

		public function __construct() {

			$this->addText('server', 'localhost', FORM_FIELD_TEXT, CONFIG_DATABASE_SERVER_MAX_LENGTH, ['required' => true]);

			$this->addText('user', '', FORM_FIELD_TEXT, CONFIG_DATABASE_USER_MAX_LENGTH, ['required' => true]);

			$this->addText('password', '', FORM_FIELD_TEXT, CONFIG_DATABASE_PASSWORD_MAX_LENGTH);

			$this->addText('name', '', FORM_FIELD_TEXT, CONFIG_DATABASE_NAME_MAX_LENGTH, ['required' => true]);
		}
	}
}
