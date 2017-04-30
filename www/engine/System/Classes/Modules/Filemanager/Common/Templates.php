<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Common {

	trait Templates {

		# Common configuration

		protected static $origin = 'templates';

		protected static $title = 'FILEMANAGER_ORIGIN_TEMPLATES';

		protected static $container_class = 'Modules\Filemanager\Container\Templates';

		protected static $permissions = ['browse' => false, 'manage' => false, 'edit' => true];

		protected static $ignore_hidden = true;
	}
}
