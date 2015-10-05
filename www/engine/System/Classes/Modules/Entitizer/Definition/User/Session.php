<?php

namespace System\Modules\Entitizer\Definition\User {

	use System\Modules\Entitizer;

	class Session extends Entitizer\Utils\Definition {

		use Entitizer\Common\User\Session;

		# Define presets

		protected function define() {

			# Add params

			$this->hash         ('code');
			$this->varchar      ('ip', null, true);
			$this->time         ('time');
		}
	}
}
