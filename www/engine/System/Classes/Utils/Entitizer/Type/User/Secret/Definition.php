<?php

namespace System\Utils\Entitizer\Type\User\Secret {

	use System\Utils\Entitizer;

	abstract class Definition extends Entitizer\Utils\Type\Extension {

		protected $type = ENTITY_TYPE_USER_SECRET, $parent = ENTITY_TYPE_USER, $table = TABLE_USERS_SECRETS;

		# Define presets

        protected function define() {

			# Add params

            $this->params->hash             ('code');
            $this->params->varchar          ('ip', null, true);
            $this->params->time             ('time');
        }
    }
}
