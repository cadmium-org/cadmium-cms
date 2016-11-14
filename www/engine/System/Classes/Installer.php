<?php

namespace {

	use Modules\Install, Utils\Schema;

	class Installer {

		# Installer handle method

		public function handle() {

			# Check installation

			if (null !== ($data = Schema::get('System')->load())) {

				Request::redirect(INSTALL_PATH . '/index.php');
			}

			# Determine handler class

			$checked = (Install::status() && Validate::boolean(Request::get('checked')));

			$class = ('Modules\Install\Handler\\' . (!$checked ? 'Check' : 'Database'));

			# ------------------------

			new $class;
		}
	}
}
