<?php

namespace Modules\Entitizer\Common {

	trait Variable {

		# Common configuration

		protected static $type = ENTITY_TYPE_VARIABLE, $table = TABLE_VARIABLES;

		protected static $auto_increment = true, $nesting = false, $super = false;

		protected static $extensions = [];
	}
}
