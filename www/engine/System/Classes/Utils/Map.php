<?php

namespace Utils {

	use Modules\Extend, Url;

	abstract class Map {

		private static $routes = [

			'/admin/login'                          => 'Modules\Auth\Handler\Login',
			'/admin/reset'                          => 'Modules\Auth\Handler\Reset',
			'/admin/recover'                        => 'Modules\Auth\Handler\Recover',
			'/admin/register'                       => 'Modules\Auth\Handler\Register',
			'/admin/content/pages'                  => 'Modules\Entitizer\Lister\Pages',
			'/admin/content/pages/create'           => 'Modules\Entitizer\Handler\Create\Page',
			'/admin/content/pages/edit'             => 'Modules\Entitizer\Handler\Edit\Page',
			'/admin/content/menuitems'              => 'Modules\Entitizer\Lister\Menuitems',
			'/admin/content/menuitems/create'       => 'Modules\Entitizer\Handler\Create\Menuitem',
			'/admin/content/menuitems/edit'         => 'Modules\Entitizer\Handler\Edit\Menuitem',
			'/admin/content/variables'              => 'Modules\Entitizer\Lister\Variables',
			'/admin/content/variables/create'       => 'Modules\Entitizer\Handler\Create\Variable',
			'/admin/content/variables/edit'         => 'Modules\Entitizer\Handler\Edit\Variable',
			'/admin/content/widgets'                => 'Modules\Entitizer\Lister\Widgets',
			'/admin/content/widgets/create'         => 'Modules\Entitizer\Handler\Create\Widget',
			'/admin/content/widgets/edit'           => 'Modules\Entitizer\Handler\Edit\Widget',
			'/admin/content/filemanager'            => 'Modules\Filemanager\Handler\Lister',
			'/admin/content/filemanager/dir'        => 'Modules\Filemanager\Handler\Dir',
			'/admin/content/filemanager/file'       => 'Modules\Filemanager\Handler\File',
			'/admin/content/filemanager/upload'     => 'Modules\Filemanager\Handler\Upload',
			'/admin/extend/addons'                  => 'Modules\Extend\Handler\Addons',
			'/admin/extend/languages'               => 'Modules\Extend\Handler\Languages',
			'/admin/extend/templates'               => 'Modules\Extend\Handler\Templates',
			'/admin/system/settings'                => 'Modules\Settings\Handler\Common',
			'/admin/system/settings/admin'          => 'Modules\Settings\Handler\Admin',
			'/admin/system/users'                   => 'Modules\Entitizer\Lister\Users',
			'/admin/system/users/create'            => 'Modules\Entitizer\Handler\Create\User',
			'/admin/system/users/edit'              => 'Modules\Entitizer\Handler\Edit\User',
			'/admin/system/information'             => 'Modules\Informer\Handler\Information',
			'/admin'                                => 'Modules\Informer\Handler\Dashboard',
			'/profile/login'                        => 'Modules\Profile\Handler\Auth\Login',
			'/profile/recover'                      => 'Modules\Profile\Handler\Auth\Recover',
			'/profile/register'                     => 'Modules\Profile\Handler\Auth\Register',
			'/profile/reset'                        => 'Modules\Profile\Handler\Auth\Reset',
			'/profile/edit'                         => 'Modules\Profile\Handler\Edit',
			'/profile'                              => 'Modules\Profile\Handler\Overview',
			'/captcha.png'                          => 'Modules\Tools\Handler\Captcha',
			'/sitemap.xml'                          => 'Modules\Tools\Handler\Sitemap'
		];

		# Parse string

		private static function parseString(string $string, string $regex) {

			$parts = preg_split('/\//', $string, 0, PREG_SPLIT_NO_EMPTY);

			foreach ($parts as $name) if (!preg_match($regex, $name)) return false;

			# ------------------------

			return $parts;
		}

		# Parse route

		private static function parseRoute(string $name, array $route) {

			if (false === ($path = self::parseString($route['path'], REGEX_MAP_ITEM_PATH))) return;

			if (false === ($handler = self::parseString($route['handler'], REGEX_MAP_ITEM_HANDLER))) return;

			self::$routes['/' . implode('/', $path)] = ('Addons\\' . $name . '\\' . implode('\\', $handler));
		}

		# Parse item

		private static function parseItem(array $item) {

			foreach ($item['routes'] as $route) self::parseRoute($item['name'], $route);
		}

		# Autoloader

		public static function __autoload() {

			foreach (Extend\Addons::items() as $item) self::parseItem($item);
		}

		# Get handler by url

		public static function handler(Url $url) {

			return (self::$routes[$url->getPath()] ?? false);
		}
	}
}
