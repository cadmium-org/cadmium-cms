<?php

namespace Modules\Entitizer\Common {

	trait Variable {

		# Common configuration

		protected static $table = TABLE_VARIABLES;

		protected static $auto_increment = true, $nesting = false, $super = false;
	}
}
