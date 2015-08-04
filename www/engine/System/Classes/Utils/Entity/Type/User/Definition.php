<?php

namespace System\Utils\Entity\Type\User {

	use System\Utils\Entity;

	/**
	 * @property-read int $rank
	 * @property-read string $name
	 * @property-read string $email
	 * @property-read string $auth_key
	 * @property-read string $password
	 * @property-read string $first_name
	 * @property-read string $last_name
	 * @property-read int $sex
	 * @property-read string $city
	 * @property-read string $country
	 * @property-read string $timezone
	 * @property-read int $time_registered
	 * @property-read int $time_logged
	 */

	class Definition extends Entity\Entity {

		const TYPE = 'User', TABLE = TABLE_USERS, HAS_SUPER = true;

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
