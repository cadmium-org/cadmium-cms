<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Action {

	use Modules\Auth;

	class Register extends Auth\Utils\Action {

		# Action configuration

		protected static $view = 'Register';

		protected static $form_class = 'Modules\Auth\Form\Register';

		protected static $controller_class = 'Modules\Auth\Controller\Register';

		protected static $redirect = '/login?submitted=register';

		protected static $messages = [];
	}
}
