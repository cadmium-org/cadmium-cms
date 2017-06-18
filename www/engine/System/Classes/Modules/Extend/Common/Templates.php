<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Common {

	trait Templates {

		# Common configuration

		protected static $extension_class = 'Modules\Extend\Templates';

		protected static $loader_class = 'Modules\Extend\Loader\Templates', $exception_class = 'Exception\Template';

		protected static $root_dir = [SECTION_SITE => DIR_SYSTEM_TEMPLATES . 'Site/', SECTION_ADMIN => DIR_SYSTEM_TEMPLATES . 'Admin/'];

		protected static $schema_prototype = 'Prototype\Template', $regex_name = REGEX_TEMPLATE_NAME;

		protected static $selectable = [SECTION_SITE => false, SECTION_ADMIN => false], $name = 'template';

		protected static $default = [SECTION_SITE => CONFIG_SITE_TEMPLATE, SECTION_ADMIN => CONFIG_ADMIN_TEMPLATE];

		protected static $param = [SECTION_SITE => 'site_template', SECTION_ADMIN => 'admin_template'];

		protected static $cookie_expires = CONFIG_TEMPLATE_COOKIE_EXPIRES;

		protected static $error_activate = 'TEMPLATES_ERROR_ACTIVATE';

		protected static $view_main = 'Blocks/Extend/Templates/Main', $view_item = 'Blocks/Extend/Templates/Item';
	}
}
