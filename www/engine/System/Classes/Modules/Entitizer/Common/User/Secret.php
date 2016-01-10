<?php

namespace Modules\Entitizer\Common\User {

	trait Secret {

		# Common configuration

		protected static $type = ENTITY_TYPE_USER_SECRET, $table = TABLE_USERS_SECRETS;

		protected static $auto_increment = false, $nesting = false, $super = false;

		protected static $extensions = [];
	}
}
