<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Form {

	use Modules\Auth, Utils\Form;

	class Recover extends Form {

		protected $name = 'recover';

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->addText('password_new', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, ['required' => true]);

			$this->addText('password_retype', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, ['required' => true]);
		}
	}
}
