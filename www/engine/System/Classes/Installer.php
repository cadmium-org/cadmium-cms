<?php

/**
 * @package Cadmium\System
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	use Modules\Install, Utils\Schema;

	class Installer {

		/**
		 * Route a request to a handler
		 */

		public function route() {

			# Check installation

			if (null !== ($data = Schema::get('System')->load())) {

				Request::redirect(INSTALL_PATH . '/index.php');
			}

			# Get handler class

			$checked = (Install::checkRequirements() && Validate::boolean(Request::get('checked')));

			$class = ('Modules\Install\Handler\\' . (!$checked ? 'Check' : 'Database'));

			# ------------------------

			new $class;
		}
	}
}
