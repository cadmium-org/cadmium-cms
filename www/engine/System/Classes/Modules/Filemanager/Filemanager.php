<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules {

	abstract class Filemanager {

		/**
		 * Get a container object for a path located within the addons directory
		 */

		public static function openAddons(string $path = '') : Filemanager\Container\Addons {

			return new Filemanager\Container\Addons($path);
		}

		/**
		 * Get a container object for a path located within the languages directory
		 */

		public static function openLanguages(string $path = '') : Filemanager\Container\Languages {

			return new Filemanager\Container\Languages($path);
		}

		/**
		 * Get a container object for a path located within the templates directory
		 */

		public static function openTemplates(string $path = '') : Filemanager\Container\Templates {

			return new Filemanager\Container\Templates($path);
		}

		/**
		 * Get a container object for a path located within the uploads directory
		 */

		public static function openUploads(string $path = '') : Filemanager\Container\Uploads {

			return new Filemanager\Container\Uploads($path);
		}

		/**
		 * Get a directory/file entity object
		 */

		public static function get(Filemanager\Utils\Container $parent, string $name = '') : Filemanager\Utils\Entity {

			return new Filemanager\Utils\Entity($parent, $name);
		}

		/**
		 * Get a loader object for a given parent
		 */

		public static function getLoader(Filemanager\Utils\Container $parent) : Filemanager\Utils\Loader {

			return new Filemanager\Utils\Loader($parent);
		}
	}
}
