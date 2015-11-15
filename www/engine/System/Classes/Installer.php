<?php

namespace System {

	use System, System\Modules\Install, Request;

	class Installer extends System {

		# Installer handle method

		public function handle() {

			# Check installation

			// if (!$this->installed) Request::redirect(INSTALL_PATH . '/index.php');

			# Determine handler class

			$checked = (Install::status() && boolval(Request::get('checked')));

			$class = ('System\Handlers\Admin\Install\\' . (!$checked ? 'Check' : 'Database'));

			# ------------------------

			new $class();
		}
	}
}
