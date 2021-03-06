<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Common\User {

	trait Secret {

		# Common configuration

		protected static $table = TABLE_USERS_SECRETS;

		protected static $auto_increment = false, $nesting = false, $super = false;
	}
}
