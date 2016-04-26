<?php

namespace {

	use Modules\Install;

	class Installer extends System {

		# Installer handle method

		public function handle() {

			# Determine handler class

			$checked = (Install::status() && Validate::boolean(Request::get('checked')));

			$class = ('Handlers\Admin\Install\\' . (!$checked ? 'Check' : 'Database'));

			# ------------------------

			new $class;
		}
	}
}
