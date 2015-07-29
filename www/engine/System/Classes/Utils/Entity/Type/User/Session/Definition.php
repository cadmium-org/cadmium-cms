<?php

namespace System\Utils\Entity\Type\User\Session {

	use System\Utils\Entity;

	class Definition extends Entity\Entity {

		const TYPE = 'User\Session', TABLE = TABLE_USERS_SESSIONS;

		# Define presets

        protected function define() {

			# Add params

            $this->params->hash             ('code');
            $this->params->varchar          ('ip', null, true);
            $this->params->time             ('time');
        }
    }
}

?>
