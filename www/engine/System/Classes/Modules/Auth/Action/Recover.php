<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Action {

	use Modules\Auth, Request, Template;

	class Recover extends Auth\Utils\Action {

		# Action configuration

		protected static $view = 'Recover';

		protected static $form_class = 'Modules\Auth\Form\Recover';

		protected static $controller_class = 'Modules\Auth\Controller\Recover';

		protected static $redirect = '/login?submitted=recover';

		protected static $messages = [];

		/**
		 * Handle the request
		 */

		public function handle() : Template\Block {

			$code = Request::get('code'); $admin = Auth::isAdmin();

			# Redirect if code is invalid

			if (false === ($result = Auth\Utils\Connector\Secret::authorize($code, $admin))) {

				Request::redirect(INSTALL_PATH . ($admin ? '/admin' : '/profile') . '/reset');
			}

			# Set recovery data

			$this->code = $result['auth']->code; $this->user = $result['user'];

			# ------------------------

			return parent::handle();
		}
	}
}
