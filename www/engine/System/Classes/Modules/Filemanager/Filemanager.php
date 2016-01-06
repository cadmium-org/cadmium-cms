<?php

namespace Modules {

	abstract class Filemanager {

		private static $classes = [

			FILEMANAGER_TYPE_DIR            => 'Modules\Filemanager\Entity\Dir',
			FILEMANAGER_TYPE_FILE           => 'Modules\Filemanager\Entity\File'
		];

		# Open container

		public static function open(string $path = '') {

			return new Filemanager\Utils\Container($path);
		}

		# Get entity

		public static function get(string $type, Filemanager\Utils\Container $parent, string $name = '') {

			$class = (($type === FILEMANAGER_TYPE_DIR) ? FILEMANAGER_TYPE_DIR : FILEMANAGER_TYPE_FILE);

			return new self::$classes[$class]($parent, $name);
		}

		# Get directory entity

		public static function dir(Filemanager\Utils\Container $parent, string $name = '') {

			return self::get(FILEMANAGER_TYPE_DIR, $parent, $name);
		}

		# Get file entity

		public static function file(Filemanager\Utils\Container $parent, string $name = '') {

			return self::get(FILEMANAGER_TYPE_FILE, $parent, $name);
		}
	}
}
