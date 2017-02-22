<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Utils\Connector {

	use Modules\Auth;

	abstract class Secret extends Auth\Utils\Connector {

		# Connector configuration

		protected static $type = TABLE_USERS_SECRETS;

		protected static $lifetime = CONFIG_USER_SECRET_LIFETIME;
	}
}
