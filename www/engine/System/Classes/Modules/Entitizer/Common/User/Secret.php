<?php

namespace Modules\Entitizer\Common\User {

	trait Secret {

		# Common configuration

		protected static $table = TABLE_USERS_SECRETS;

		protected static $auto_increment = false, $nesting = false, $super = false;
	}
}
