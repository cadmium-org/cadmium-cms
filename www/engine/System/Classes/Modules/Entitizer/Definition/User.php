<?php

namespace System\Modules\Entitizer\Definition {

	use System\Modules\Entitizer;

	class User extends Entitizer\Utils\Definition {

		use Entitizer\Common\User;

		# Define presets

		protected function define() {

			# Add params

			$this->numeric      ('rank',            true, 1, RANK_USER, true, false);
			$this->textual      ('name',            true, 16, false, true, true);
			$this->textual      ('email',           true, 128, false, true, true);
			$this->textual      ('auth_key',        true, 40, true, false, false);
			$this->textual      ('password',        true, 40, true, false, false);
			$this->textual      ('first_name',      true, 255, false, false, false);
			$this->textual      ('last_name',       true, 255, false, false, false);
			$this->numeric      ('sex',             true, 1, SEX_NOT_SELECTED, false, false);
			$this->textual      ('city',            true, 255, false, false, false);
			$this->textual      ('country',         true, 2, false, false, false);
			$this->textual      ('timezone',        true, 40, false, false, false);
			$this->numeric      ('time_registered', false, 10, 0, true, false);
			$this->numeric      ('time_logged',     false, 10, 0, true, false);
		}
	}
}
