<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils {

	use Modules\Extend, Url;

	abstract class Router {

		private static $routes = [

			'/admin/login'                                  => 'Modules\Auth\Handler\Login',
			'/admin/reset'                                  => 'Modules\Auth\Handler\Reset',
			'/admin/recover'                                => 'Modules\Auth\Handler\Recover',
			'/admin/register'                               => 'Modules\Auth\Handler\Register',
			'/admin/content/pages'                          => 'Modules\Entitizer\Lister\Pages',
			'/admin/content/pages/create'                   => 'Modules\Entitizer\Handler\Create\Page',
			'/admin/content/pages/edit'                     => 'Modules\Entitizer\Handler\Edit\Page',
			'/admin/content/menuitems'                      => 'Modules\Entitizer\Lister\Menuitems',
			'/admin/content/menuitems/create'               => 'Modules\Entitizer\Handler\Create\Menuitem',
			'/admin/content/menuitems/edit'                 => 'Modules\Entitizer\Handler\Edit\Menuitem',
			'/admin/content/variables'                      => 'Modules\Entitizer\Lister\Variables',
			'/admin/content/variables/create'               => 'Modules\Entitizer\Handler\Create\Variable',
			'/admin/content/variables/edit'                 => 'Modules\Entitizer\Handler\Edit\Variable',
			'/admin/content/widgets'                        => 'Modules\Entitizer\Lister\Widgets',
			'/admin/content/widgets/create'                 => 'Modules\Entitizer\Handler\Create\Widget',
			'/admin/content/widgets/edit'                   => 'Modules\Entitizer\Handler\Edit\Widget',
			'/admin/content/filemanager'                    => 'Modules\Filemanager\Lister\Uploads',
			'/admin/content/filemanager/addons'             => 'Modules\Filemanager\Lister\Addons',
			'/admin/content/filemanager/addons/dir'         => 'Modules\Filemanager\Handler\Dir\Addons',
			'/admin/content/filemanager/addons/file'        => 'Modules\Filemanager\Handler\File\Addons',
			'/admin/content/filemanager/languages'          => 'Modules\Filemanager\Lister\Languages',
			'/admin/content/filemanager/languages/dir'      => 'Modules\Filemanager\Handler\Dir\Languages',
			'/admin/content/filemanager/languages/file'     => 'Modules\Filemanager\Handler\File\Languages',
			'/admin/content/filemanager/templates'          => 'Modules\Filemanager\Lister\Templates',
			'/admin/content/filemanager/templates/dir'      => 'Modules\Filemanager\Handler\Dir\Templates',
			'/admin/content/filemanager/templates/file'     => 'Modules\Filemanager\Handler\File\Templates',
			'/admin/content/filemanager/uploads'            => 'Modules\Filemanager\Lister\Uploads',
			'/admin/content/filemanager/uploads/dir'        => 'Modules\Filemanager\Handler\Dir\Uploads',
			'/admin/content/filemanager/uploads/file'       => 'Modules\Filemanager\Handler\File\Uploads',
			'/admin/content/filemanager/upload'             => 'Modules\Filemanager\Handler\Upload',
			'/admin/extend/addons'                          => 'Modules\Extend\Handler\Addons',
			'/admin/extend/languages'                       => 'Modules\Extend\Handler\Languages',
			'/admin/extend/templates'                       => 'Modules\Extend\Handler\Templates',
			'/admin/system/settings'                        => 'Modules\Settings\Handler\Common',
			'/admin/system/settings/admin'                  => 'Modules\Settings\Handler\Admin',
			'/admin/system/users'                           => 'Modules\Entitizer\Lister\Users',
			'/admin/system/users/create'                    => 'Modules\Entitizer\Handler\Create\User',
			'/admin/system/users/edit'                      => 'Modules\Entitizer\Handler\Edit\User',
			'/admin/system/information'                     => 'Modules\Informer\Handler\Information',
			'/admin'                                        => 'Modules\Informer\Handler\Dashboard',
			'/profile/login'                                => 'Modules\Profile\Handler\Auth\Login',
			'/profile/recover'                              => 'Modules\Profile\Handler\Auth\Recover',
			'/profile/register'                             => 'Modules\Profile\Handler\Auth\Register',
			'/profile/reset'                                => 'Modules\Profile\Handler\Auth\Reset',
			'/profile/edit'                                 => 'Modules\Profile\Handler\Edit',
			'/profile'                                      => 'Modules\Profile\Handler\Overview',
			'/captcha.png'                                  => 'Modules\Tools\Handler\Captcha',
			'/sitemap.xml'                                  => 'Modules\Tools\Handler\Sitemap'
		];

		/**
		 * Parse a path/handler
		 *
		 * @return string : the parsed path/handler
		 */

		private static function parseString(string $string, string $regex) {

			$parts = preg_split('/\//', $string, 0, PREG_SPLIT_NO_EMPTY);

			foreach ($parts as $name) if (!preg_match($regex, $name)) return false;

			# ------------------------

			return $parts;
		}

		/**
		 * Parse a route
		 */

		private static function parseRoute(string $name, array $route) {

			if (false === ($path = self::parseString($route['path'], REGEX_MAP_ITEM_PATH))) return;

			if (false === ($handler = self::parseString($route['handler'], REGEX_MAP_ITEM_HANDLER))) return;

			self::$routes['/' . implode('/', $path)] = ('Addons\\' . $name . '\\' . implode('\\', $handler));
		}

		/**
		 * Autoloader
		 */

		public static function __autoload() {

			foreach (Extend\Addons::getItems() as $item) {

				foreach ($item['routes'] as $route) self::parseRoute($item['name'], $route);
			}
		}

		/**
		 * Get a handler class by a url
		 *
		 * @return string : a class name or false if a handler for the given url is not set
		 */

		public static function getHandler(Url $url) {

			return (self::$routes[$url->getPath()] ?? false);
		}
	}
}
