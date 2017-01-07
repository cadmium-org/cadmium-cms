<?php

/**
 * @package Cadmium\System\Modules\Install
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Install\Form {

	use Utils\Form;

	class Database extends Form {

		protected $name = 'database';

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->addText('server', 'localhost', FORM_FIELD_TEXT, CONFIG_DATABASE_SERVER_MAX_LENGTH, ['required' => true]);

			$this->addText('user', '', FORM_FIELD_TEXT, CONFIG_DATABASE_USER_MAX_LENGTH, ['required' => true]);

			$this->addText('password', '', FORM_FIELD_TEXT, CONFIG_DATABASE_PASSWORD_MAX_LENGTH);

			$this->addText('name', '', FORM_FIELD_TEXT, CONFIG_DATABASE_NAME_MAX_LENGTH, ['required' => true]);
		}
	}
}
