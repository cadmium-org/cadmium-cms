<?php

/**
 * @package Cadmium\System\Addons\Contact
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Addons\Contact {

	use Addons, Modules\Auth, Utils;

	class Form extends Utils\Form {

		protected $name = 'contact';

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->addText('name', Auth::get('full_name'), FORM_FIELD_TEXT, Addons\Contact::NAME_MAX_LENGTH, ['required' => true]);

			$this->addText('email', Auth::get('email'), FORM_FIELD_TEXT, Addons\Contact::EMAIL_MAX_LENGTH, ['required' => true]);

			$this->addText('message', '', FORM_FIELD_TEXTAREA, Addons\Contact::MESSAGE_MAX_LENGTH, ['required' => true]);

			$this->addText('captcha', '', FORM_FIELD_CAPTCHA, Addons\Contact::CAPTCHA_MAX_LENGTH, ['required' => true]);
		}
	}
}
