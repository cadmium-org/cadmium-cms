<?php

namespace System\Utils\Entitizer\Type\User {

	use System\Utils\Entitizer;

	abstract class Definition extends Entitizer\Utils\Type\General {

		protected $type = ENTITY_TYPE_USER, $table = TABLE_USERS, $super = true;

		protected $extensions = array(ENTITY_TYPE_USER_SECRET, ENTITY_TYPE_USER_SESSION);

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
        }
    }
}
