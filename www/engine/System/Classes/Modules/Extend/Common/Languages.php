<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Common {

	trait Languages {

		# Common configuration

		protected static $extension_class = 'Modules\Extend\Languages';

		protected static $loader_class = 'Modules\Extend\Loader\Languages', $exception_class = 'Exception\Language';

		protected static $root_dir = [SECTION_SITE => DIR_SYSTEM_LANGUAGES, SECTION_ADMIN => DIR_SYSTEM_LANGUAGES];

		protected static $schema_prototype = 'Prototype\Language', $regex_name = REGEX_LANGUAGE_NAME;

		protected static $selectable = [SECTION_SITE => false, SECTION_ADMIN => true], $name = 'language';

		protected static $default = [SECTION_SITE => CONFIG_SITE_LANGUAGE, SECTION_ADMIN => CONFIG_ADMIN_LANGUAGE];

		protected static $param = [SECTION_SITE => 'site_language', SECTION_ADMIN => 'admin_language'];

		protected static $cookie_expires = CONFIG_LANGUAGE_COOKIE_EXPIRES;

		protected static $error_activate = 'LANGUAGES_ERROR_ACTIVATE';

		protected static $view_main = 'Blocks/Extend/Languages/Main', $view_item = 'Blocks/Extend/Languages/Item';
	}
}
