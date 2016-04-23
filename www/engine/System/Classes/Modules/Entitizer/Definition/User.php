<?php

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class User extends Entitizer\Utils\Definition {

		use Entitizer\Common\User;

		# Define presets

		protected function define() {

			# Add params

			$this->params->integer      ('rank',                true, 1, true, RANK_GUEST);
			$this->params->textual      ('name',                true, 16, false, '');
			$this->params->textual      ('email',               true, 128, false, '');
			$this->params->textual      ('auth_key',            true, 40, true, '');
			$this->params->textual      ('password',            true, 40, true, '');
			$this->params->textual      ('first_name',          true, 255, false, '');
			$this->params->textual      ('last_name',           true, 255, false, '');
			$this->params->integer      ('sex',                 true, 1, true, SEX_NOT_SELECTED);
			$this->params->textual      ('city',                true, 255, false, '');
			$this->params->textual      ('country',             true, 2, false, '');
			$this->params->textual      ('timezone',            true, 40, false, '');
			$this->params->integer      ('time_registered',     false, 10, true, 0);
			$this->params->integer      ('time_logged',         false, 10, true, 0);

			# Add indexes

			$this->indexes->add         ('rank');
			$this->indexes->add         ('name',                'UNIQUE');
			$this->indexes->add         ('email',               'UNIQUE');
			$this->indexes->add         ('time_registered');
			$this->indexes->add         ('time_logged');
		}
	}
}
