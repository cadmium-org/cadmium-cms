<?php

namespace System\Modules\Entitizer\Definition\User {

	use System\Modules\Entitizer;

	class Secret extends Entitizer\Utils\Definition {

		use Entitizer\Common\User\Secret;

		# Define presets

        protected function define() {

			# Add params

            $this->hash         ('code');
            $this->varchar      ('ip', null, true);
            $this->time         ('time');
        }
    }
}
