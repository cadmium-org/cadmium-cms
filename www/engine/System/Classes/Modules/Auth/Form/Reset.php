<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Form {

	use Modules\Auth, Utils\Form;

	class Reset extends Form {

		protected $name = 'reset';

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->addText('name_email', '', FORM_FIELD_TEXT, CONFIG_USER_EMAIL_MAX_LENGTH, ['required' => true]);

			$this->addText('captcha', '', FORM_FIELD_CAPTCHA, CONFIG_USER_CAPTCHA_MAX_LENGTH, ['required' => true]);
		}
	}
}
