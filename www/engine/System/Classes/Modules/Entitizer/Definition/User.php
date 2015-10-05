<?php

namespace System\Modules\Entitizer\Definition {

	use System\Modules\Entitizer;

	class User extends Entitizer\Utils\Definition {

		use Entitizer\Common\User;

		# Define presets

		protected function define() {

			# Add params

			$this->range        ('rank', RANK_USER);
			$this->unique       ('name');
			$this->unique       ('email');
			$this->varchar      ('auth_key', 40);
			$this->varchar      ('password', 40);
			$this->varchar      ('first_name');
			$this->varchar      ('last_name');
			$this->range        ('sex');
			$this->varchar      ('city');
			$this->varchar      ('country', 2);
			$this->varchar      ('timezone', 40);
			$this->time         ('time_registered');
			$this->time         ('time_logged');
		}
	}
}
