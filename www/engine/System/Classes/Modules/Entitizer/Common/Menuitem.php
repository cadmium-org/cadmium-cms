<?php

namespace System\Modules\Entitizer\Common {

	trait Menuitem {

		protected static $type = ENTITY_TYPE_MENUITEM, $table = TABLE_MENU;

		protected static $auto_increment = true, $nesting = true, $super = false;

		protected static $extensions = [];
    }
}
