<?php

namespace Modules\Extend\Common {

	trait Templates {

		# Common configuration

		protected static $extension_class = 'Modules\Extend\Templates';

		protected static $loader_class = 'Modules\Extend\Loader\Templates', $exception_class = 'Exception\Template';

		protected static $root_dir = [SECTION_ADMIN => DIR_SYSTEM_TEMPLATES . 'Admin/', SECTION_SITE => DIR_SYSTEM_TEMPLATES . 'Site/'];

		protected static $schema_prototype = 'Prototype\Template', $regex_name = REGEX_TEMPLATE_NAME;

		protected static $selectable = [SECTION_ADMIN => false, SECTION_SITE => false], $name = 'template';

		protected static $default = [SECTION_ADMIN => CONFIG_ADMIN_TEMPLATE_DEFAULT, SECTION_SITE => CONFIG_SITE_TEMPLATE_DEFAULT];

		protected static $param = [SECTION_ADMIN => 'admin_template', SECTION_SITE => 'site_template'];

		protected static $cookie_expires = CONFIG_TEMPLATE_COOKIE_EXPIRES;

		protected static $error_activate = 'TEMPLATES_ERROR_ACTIVATE', $errors_save = 'TEMPLATES_ERROR_SAVE';

		protected static $view_main = 'Blocks/Extend/Templates/Main', $view_item = 'Blocks/Extend/Templates/Item';
	}
}