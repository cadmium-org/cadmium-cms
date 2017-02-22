<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Action {

	use Modules\Auth;

	class Login extends Auth\Utils\Action {

		# Action configuration

		protected static $view = 'Login';

		protected static $form_class = 'Modules\Auth\Form\Login';

		protected static $controller_class = 'Modules\Auth\Controller\Login';

		protected static $redirect = '';

		protected static $messages = [

			'reset' => ['text' => 'USER_SUCCESS_RESET_TEXT', 'title' => 'USER_SUCCESS_RESET'],

			'recover' => ['text' => 'USER_SUCCESS_RECOVER_TEXT', 'title' => 'USER_SUCCESS_RECOVER'],

			'register' => ['text' => 'USER_SUCCESS_REGISTER_TEXT', 'title' => 'USER_SUCCESS_REGISTER']
		];
	}
}
