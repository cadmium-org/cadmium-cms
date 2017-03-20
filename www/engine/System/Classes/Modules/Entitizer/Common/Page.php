<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Common {

	trait Page {

		# Common configuration

		protected static $table = TABLE_PAGES, $table_relations = TABLE_PAGES_RELATIONS;

		protected static $auto_increment = true, $nesting = true, $super = true;
	}
}
