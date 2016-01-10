<?php

namespace Modules\Extend {

	abstract class Templates {

		use Utils\Extension;

		protected static $error_directory   = 'Templates directory does not exist';
		protected static $error_select      = 'Templates not found';

		protected static $name = 'template', $root_dir = DIR_SYSTEM_TEMPLATES, $separate = true;

		protected static $selectable = [SECTION_ADMIN => true, SECTION_SITE => false];

		protected static $param = [SECTION_ADMIN => 'admin_template', SECTION_SITE => 'site_template'];

		protected static $default = [SECTION_ADMIN => CONFIG_ADMIN_TEMPLATE_DEFAULT, SECTION_SITE => CONFIG_SITE_TEMPLATE_DEFAULT];

		protected static $regex_name = REGEX_TEMPLATE_NAME;

		protected static $data = ['name', 'title', 'author'];

		protected static $cookie_expires = CONFIG_TEMPLATE_COOKIE_EXPIRES;
	}
}
