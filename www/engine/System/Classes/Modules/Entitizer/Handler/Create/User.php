<?php

namespace Modules\Entitizer\Handler\Create {

	use Modules\Entitizer;

	class User extends Entitizer\Handler\Edit\User {

		protected $title = 'TITLE_SYSTEM_USERS_CREATE';

		protected $create = true;
	}
}
