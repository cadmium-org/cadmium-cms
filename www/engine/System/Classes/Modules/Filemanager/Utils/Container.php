<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Utils {

	use Explorer;

	abstract class Container {

		private $scheme = [], $path = '';

		protected $path_full = '';

		/**
		 * Constructor
		 */

		public function __construct(string $path = '') {

			$scheme = array_diff(preg_split('/[\/\\\\]+/', $path, -1, PREG_SPLIT_NO_EMPTY), ['.', '..']);

			$path_full = ($this->path_full . (('' !== ($path = implode('/', $scheme))) ? ($path . '/') : ''));

			if (!Explorer::isDir($path_full)) return;

			$this->scheme = $scheme; $this->path = $path; $this->path_full = $path_full;
		}

		/**
		 * Get the container breadcrumbs
		 *
		 * @return array : the list of ancestor directories where each item is an array of type
		 *         ['origin' => $origin, 'path' => $path, 'name' => $name], where $origin is a container's origin directory name,
		 *         $path is a directory's relative path, and $name is an directory's file name
		 */

		public function getBreadcrumbs() : array {

			$scheme = []; $breadcrumbs = [];

			foreach ($this->scheme as $name) {

				$scheme[] = $name; $path = implode('/', $scheme);

				$breadcrumbs[] = ['origin' => static::$origin, 'path' => $path, 'name' => $name];
			}

			# ------------------------

			return $breadcrumbs;
		}

		/**
		 * Get the container relative path
		 */

		public function getPath() : string {

			return $this->path;
		}

		/**
		 * Get the container full path
		 */

		public function getPathFull() : string {

			return $this->path_full;
		}

		/**
		 * Get the origin directory name
		 */

		public function getOrigin() : string {

			return static::$origin;
		}

		/**
		 * Get the list of container permissions (inherited from origin)
		 */

		public function getPermissions() : array {

			return static::$permissions;
		}

		/**
		 * Check whether the container is set to ignore hidden files or not (inherited from origin)
		 */

		public function isIgnoreHidden() : bool {

			return static::$ignore_hidden;
		}
	}
}
