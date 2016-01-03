<?php

namespace System {

	use System, System\Modules\Install, Request, Validate;

	class Installer extends System {

		# Installer handle method

		public function handle() {

			# Determine handler class

			$checked = (Install::status() && Validate::boolean(Request::get('checked')));

			$class = ('System\Handlers\Admin\Install\\' . (!$checked ? 'Check' : 'Database'));

			# ------------------------

			new $class();
		}
	}
}
