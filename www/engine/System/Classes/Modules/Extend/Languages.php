<?php

namespace System\Modules\Extend {

	abstract class Languages {

		use Utils\Extension;

		protected static $error_directory   = 'Languages directory does not exist';
		protected static $error_select      = 'Languages not found';

		protected static $name = 'language', $root_dir = DIR_SYSTEM_LANGUAGES, $separate = false;

		protected static $selectable = [SECTION_ADMIN => true, SECTION_SITE => false];

		protected static $param = [SECTION_ADMIN => 'admin_language', SECTION_SITE => 'site_language'];

		protected static $default = [SECTION_ADMIN => CONFIG_ADMIN_LANGUAGE_DEFAULT, SECTION_SITE => CONFIG_SITE_LANGUAGE_DEFAULT];

		protected static $regex_name = REGEX_LANGUAGE_NAME;

		protected static $data = ['name', 'iso', 'country', 'title', 'author'];

		protected static $cookie_expires = CONFIG_LANGUAGE_COOKIE_EXPIRES;
	}
}
