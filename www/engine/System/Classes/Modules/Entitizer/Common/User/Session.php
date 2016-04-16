<?php

namespace Modules\Entitizer\Common\User {

	trait Session {

		# Common configuration

		protected static $table = TABLE_USERS_SESSIONS;

		protected static $auto_increment = false, $nesting = false, $super = false;
	}
}
