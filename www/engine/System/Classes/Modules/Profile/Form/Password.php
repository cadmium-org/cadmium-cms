<?php

/**
 * @package Cadmium\System\Modules\Profile
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Profile\Form {

	use Utils\Form;

	class Password extends Form {

		protected $name = 'edit';

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->addText('password', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, ['required' => true]);

			$this->addText('password_new', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, ['required' => true]);

			$this->addText('password_retype', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, ['required' => true]);
		}
	}
}
