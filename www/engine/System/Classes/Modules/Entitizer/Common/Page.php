<?php

namespace Modules\Entitizer\Common {

	trait Page {

		# Common configuration

		protected static $type = ENTITY_TYPE_PAGE, $table = TABLE_PAGES;

		protected static $auto_increment = true, $nesting = true, $super = true;

		protected static $extensions = [];
	}
}
