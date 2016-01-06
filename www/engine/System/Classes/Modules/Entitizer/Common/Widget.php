<?php

namespace Modules\Entitizer\Common {

	trait Widget {

		# Common configuration

		protected static $type = ENTITY_TYPE_WIDGET, $table = TABLE_WIDGETS;

		protected static $auto_increment = true, $nesting = false, $super = false;

		protected static $extensions = [];
	}
}
