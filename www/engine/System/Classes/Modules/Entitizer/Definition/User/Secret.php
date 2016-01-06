<?php

namespace Modules\Entitizer\Definition\User {

	use Modules\Entitizer;

	class Secret extends Entitizer\Utils\Definition {

		use Entitizer\Common\User\Secret;

		# Define presets

		protected function define() {

			# Add params

			$this->addTextual       ('code',            true, 40, true, true, true);
			$this->addTextual       ('ip',              true, 255, false, true, false);
			$this->addInteger       ('time',            false, 10, 0, true, false);
		}
	}
}
