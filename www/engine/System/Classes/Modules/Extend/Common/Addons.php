<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Common {

	trait Addons {

		# Common configuration

		protected static $extension_class = 'Modules\Extend\Addons';

		protected static $loader_class = 'Modules\Extend\Loader\Addons';

		protected static $root_dir = (DIR_SYSTEM_CLASSES . 'Addons/');

		protected static $schema_prototype = 'Prototype\Addon', $schema = 'Addons', $regex_name = REGEX_ADDON_NAME;

		protected static $error_install = 'ADDONS_ERROR_INSTALL', $errors_uninstall = 'ADDONS_ERROR_UNINSTALL';

		protected static $view_main = 'Blocks/Extend/Addons/Main', $view_item = 'Blocks/Extend/Addons/Item';
	}
}
