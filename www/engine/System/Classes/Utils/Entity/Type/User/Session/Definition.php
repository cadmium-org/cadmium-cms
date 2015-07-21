<?php

namespace System\Utils\Entity\Type\User\Session {

	use System\Utils\Entity;

	class Definition extends Entity\Entity {

		protected $table = TABLE_USERS_SESSIONS;

		# Define params

        protected function define() {

            $this->params->hash             ('code');
            $this->params->varchar          ('ip', null, true);
            $this->params->time             ('time');
        }
    }
}

?>
