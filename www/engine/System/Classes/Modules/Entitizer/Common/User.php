<?php

namespace System\Modules\Entitizer\Common {

	trait User {

		# Common configuration

		protected static $type = ENTITY_TYPE_USER, $table = TABLE_USERS;

		protected static $auto_increment = true, $nesting = false, $super = true;

		protected static $extensions = [ENTITY_TYPE_USER_SECRET, ENTITY_TYPE_USER_SESSION];
	}
}
