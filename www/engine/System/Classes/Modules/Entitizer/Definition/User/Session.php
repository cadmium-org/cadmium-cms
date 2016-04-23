<?php

namespace Modules\Entitizer\Definition\User {

	use Modules\Entitizer;

	class Session extends Entitizer\Utils\Definition {

		use Entitizer\Common\User\Session;

		# Define presets

		protected function define() {

			# Add params

			$this->params->textual      ('code',                true, 40, true, '');
			$this->params->textual      ('ip',                  true, 255, false, '');
			$this->params->integer      ('time',                false, 10, true, 0);

			# Add indexes

			$this->indexes->add         ('code',                'UNIQUE');
			$this->indexes->add         ('ip');
			$this->indexes->add         ('time');

			# Add foreign keys

			$this->foreigns->add        ('id',                  TABLE_USERS, 'id', 'CASCADE', 'RESTRICT');
		}
	}
}
