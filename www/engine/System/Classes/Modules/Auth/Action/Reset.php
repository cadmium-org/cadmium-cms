<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Action {

	use Modules\Auth;

	class Reset extends Auth\Utils\Action {

		# Action configuration

		protected static $view = 'Reset';

		protected static $form_class = 'Modules\Auth\Form\Reset';

		protected static $controller_class = 'Modules\Auth\Controller\Reset';

		protected static $redirect = '/login?submitted=reset';

		protected static $messages = [];
	}
}
