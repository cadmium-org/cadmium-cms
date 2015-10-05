<?php

namespace System\Modules\Entitizer\Common\User {

	trait Session {

		protected static $type = ENTITY_TYPE_USER_SESSION, $table = TABLE_USERS_SESSIONS;

		protected static $auto_increment = false, $nesting = false, $super = false;

		protected static $extensions = [];
	}
}
