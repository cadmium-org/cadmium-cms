<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Common {

	trait Variable {

		# Common configuration

		protected static $table = TABLE_VARIABLES;

		protected static $auto_increment = true, $nesting = false, $super = false;
	}
}
