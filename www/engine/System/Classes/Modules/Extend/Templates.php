<?php

namespace System\Modules\Extend {

	abstract class Templates {

		use Utils\Extension;

		protected static $error_directory   = 'Templates directory does not exist';
		protected static $error_select      = 'Templates not found';

		protected static $name = 'template', $root_dir = DIR_SYSTEM_TEMPLATES, $separate = true;

		protected static $selectable = array(SECTION_ADMIN => true, SECTION_SITE => false);

		protected static $param = array(SECTION_ADMIN => 'admin_template', SECTION_SITE => 'site_template');

		protected static $default = array(SECTION_ADMIN => CONFIG_ADMIN_TEMPLATE_DEFAULT, SECTION_SITE => CONFIG_SITE_TEMPLATE_DEFAULT);

		protected static $regex_name = REGEX_TEMPLATE_NAME;

		protected static $data = array('name', 'title', 'author');

		protected static $cookie_expires = CONFIG_TEMPLATE_COOKIE_EXPIRES;
	}
}
