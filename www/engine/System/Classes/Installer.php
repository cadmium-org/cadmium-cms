<?php

namespace System {

	use System, System\Handlers, System\Modules\Install, Request;

	class Installer extends System {

		# Installer main method

		public function handle() {

			# Handle request

			$checked = (Install::status() && boolval(Request::get('checked')));

			return (!$checked ? new Handlers\Admin\Install\Check() : new Handlers\Admin\Install\Database());
		}
	}
}
