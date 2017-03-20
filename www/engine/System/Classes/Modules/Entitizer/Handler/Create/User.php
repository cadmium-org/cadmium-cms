<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Handler\Create {

	use Modules\Entitizer;

	class User extends Entitizer\Handler\Edit\User {

		protected $_title = 'TITLE_SYSTEM_USERS_CREATE';

		protected $create = true;
	}
}
