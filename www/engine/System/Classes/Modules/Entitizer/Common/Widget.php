<?php

namespace Modules\Entitizer\Common {

	trait Widget {

		# Common configuration

		protected static $table = TABLE_WIDGETS;

		protected static $auto_increment = true, $nesting = false, $super = false;
	}
}
