<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Common {

	trait Addons {

		# Common configuration

		protected static $origin = 'addons';

		protected static $title = 'FILEMANAGER_ORIGIN_ADDONS';

		protected static $container_class = 'Modules\Filemanager\Container\Addons';

		protected static $permissions = ['browse' => false, 'manage' => false, 'edit' => true];

		protected static $ignore_hidden = true;
	}
}
