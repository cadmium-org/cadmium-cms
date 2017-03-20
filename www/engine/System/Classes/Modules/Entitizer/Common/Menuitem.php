<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Common {

	trait Menuitem {

		# Common configuration

		protected static $table = TABLE_MENU, $table_relations = TABLE_MENU_RELATIONS;

		protected static $auto_increment = true, $nesting = true, $super = false;
	}
}
