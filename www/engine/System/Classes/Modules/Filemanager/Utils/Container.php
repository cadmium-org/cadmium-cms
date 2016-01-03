<?php

namespace System\Modules\Filemanager\Utils {

	use Explorer;

	class Container {

		private $scheme = [], $path = '', $path_full = DIR_UPLOADS;

		# Constructor

		public function __construct(string $path = '') {

			$scheme = array_diff(preg_split('/[\/\\\\]+/', $path, -1, PREG_SPLIT_NO_EMPTY), ['.', '..']);

			$path = implode('/', $scheme); $path_full = (DIR_UPLOADS . (('' !== $path) ? ($path . '/') : ''));

			if (!Explorer::isDir($path_full)) return;

			$this->scheme = $scheme; $this->path = $path; $this->path_full = $path_full;
		}

		# Get breadcrumbs

		public function breadcrumbs() {

			$scheme = []; $breadcrumbs = [];

			if ([] !== $this->scheme) foreach ($this->scheme as $name) {

				$scheme[] = $name; $breadcrumbs[] = ['path' => implode('/', $scheme), 'name' => $name];
			}

			# ------------------------

			return $breadcrumbs;
		}

		# Return path

		public function path() {

			return $this->path;
		}

		# Return full path

		public function pathFull() {

			return $this->path_full;
		}
	}
}
