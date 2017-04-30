<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Common {

	trait Uploads {

		# Common configuration

		protected static $origin = 'uploads';

		protected static $title = 'FILEMANAGER_ORIGIN_UPLOADS';

		protected static $container_class = 'Modules\Filemanager\Container\Uploads';

		protected static $permissions = ['browse' => true, 'manage' => true, 'edit' => false];

		protected static $ignore_hidden = true;
	}
}
