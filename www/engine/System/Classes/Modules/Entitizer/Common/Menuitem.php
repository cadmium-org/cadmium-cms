<?php

namespace Modules\Entitizer\Common {

	trait Menuitem {

		# Common configuration

		protected static $table = TABLE_MENU, $table_relations = TABLE_MENU_RELATIONS;

		protected static $auto_increment = true, $nesting = true, $super = false;
	}
}
