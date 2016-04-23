<?php

namespace Modules\Entitizer\Common {

	trait User {

		# Common configuration

		protected static $table = TABLE_USERS;

		protected static $auto_increment = true, $nesting = false, $super = true;
	}
}
