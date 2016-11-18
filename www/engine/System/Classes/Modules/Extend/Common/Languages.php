<?php

namespace Modules\Extend\Common {

	trait Languages {

		# Common configuration

		protected static $extension_class = 'Modules\Extend\Languages';

		protected static $loader_class = 'Modules\Extend\Loader\Languages', $exception_class = 'Exception\Language';

		protected static $root_dir = [SECTION_ADMIN => DIR_SYSTEM_LANGUAGES, SECTION_SITE => DIR_SYSTEM_LANGUAGES];

		protected static $schema_prototype = 'Prototype\Language', $regex_name = REGEX_LANGUAGE_NAME;

		protected static $selectable = [SECTION_ADMIN => true, SECTION_SITE => false], $name = 'language';

		protected static $default = [SECTION_ADMIN => CONFIG_ADMIN_LANGUAGE_DEFAULT, SECTION_SITE => CONFIG_SITE_LANGUAGE_DEFAULT];

		protected static $param = [SECTION_ADMIN => 'admin_language', SECTION_SITE => 'site_language'];

		protected static $cookie_expires = CONFIG_LANGUAGE_COOKIE_EXPIRES;

		protected static $error_activate = 'LANGUAGES_ERROR_ACTIVATE', $errors_save = 'LANGUAGES_ERROR_SAVE';

		protected static $view_main = 'Blocks/Extend/Languages/Main', $view_item = 'Blocks/Extend/Languages/Item';
	}
}