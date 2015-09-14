<?php

namespace System {

	use System, System\Modules\Install, Request;

	class Installer extends System {

		# Installer handle method

		public function handle() {

			$checked = (Install::status() && boolval(Request::get('checked')));

			$class = ('System\Handlers\Admin\Install\\' . (!$checked ? 'Check' : 'Database'));

			# ------------------------

			new $class();
		}
	}
}
