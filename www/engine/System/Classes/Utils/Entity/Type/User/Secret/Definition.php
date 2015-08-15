<?php

namespace System\Utils\Entity\Type\User\Secret {

	use System\Utils\Entity;

	class Definition extends Entity {

		const TYPE = 'User\Secret', TABLE = TABLE_USERS_SECRETS;

		# Define presets

        protected function define() {

			# Add params

            $this->params->hash             ('code');
            $this->params->varchar          ('ip', null, true);
            $this->params->time             ('time');
        }
    }
}
