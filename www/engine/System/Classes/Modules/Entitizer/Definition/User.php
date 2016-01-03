<?php

namespace System\Modules\Entitizer\Definition {

	use System\Modules\Entitizer;

	class User extends Entitizer\Utils\Definition {

		use Entitizer\Common\User;

		# Define presets

		protected function define() {

			# Add params

			$this->addInteger       ('rank',            true, 1, RANK_USER, true, false);
			$this->addTextual       ('name',            true, 16, false, true, true);
			$this->addTextual       ('email',           true, 128, false, true, true);
			$this->addTextual       ('auth_key',        true, 40, true, false, false);
			$this->addTextual       ('password',        true, 40, true, false, false);
			$this->addTextual       ('first_name',      true, 255, false, false, false);
			$this->addTextual       ('last_name',       true, 255, false, false, false);
			$this->addInteger       ('sex',             true, 1, SEX_NOT_SELECTED, false, false);
			$this->addTextual       ('city',            true, 255, false, false, false);
			$this->addTextual       ('country',         true, 2, false, false, false);
			$this->addTextual       ('timezone',        true, 40, false, false, false);
			$this->addInteger       ('time_registered', false, 10, 0, true, false);
			$this->addInteger       ('time_logged',     false, 10, 0, true, false);

			# Add orderers

			$this->addOrderer       ('rank', true);
			$this->addOrderer       ('name');
		}
	}
}
