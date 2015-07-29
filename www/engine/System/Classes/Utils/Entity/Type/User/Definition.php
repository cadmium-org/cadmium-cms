<?php

namespace System\Utils\Entity\Type\User {

	use System\Utils\Entity;

	class Definition extends Entity\Entity {

		const TYPE = 'User', TABLE = TABLE_USERS, SUPER = true;

		# Define presets

        protected function define() {

			# Add params

            $this->params->range            ('rank', RANK_USER);
            $this->params->unique           ('name');
            $this->params->unique           ('email');
            $this->params->varchar          ('auth_key', 40);
            $this->params->varchar        	('password', 40);
            $this->params->varchar          ('first_name');
            $this->params->varchar          ('last_name');
            $this->params->range            ('sex');
            $this->params->varchar          ('city');
            $this->params->varchar          ('country', 2);
            $this->params->varchar          ('timezone', 40);
            $this->params->time             ('time_registered');
            $this->params->time             ('time_logged');

			# Add foreign relations

			$this->addForeign('User\Secret',   'id');
			$this->addForeign('User\Session',  'id');
        }
    }
}

?>
