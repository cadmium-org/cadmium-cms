<?php

namespace System\Modules {

	abstract class Install {

		private static $requirements = [], $status = false;

		# Autoloader

		public static function __autoload() {

			# Check extensions

			$extensions = ['mysqli', 'mbstring', 'gd', 'simplexml'];

			foreach ($extensions as $name) self::$requirements[$name] = extension_loaded($name);

			# Check mod_rewrite

			$rewrite = (getenv('HTTP_MOD_REWRITE') === 'on');

			self::$requirements['rewrite'] = $rewrite;

			# Check writables

			$writables = ['data' => DIR_SYSTEM_DATA, 'uploads' => DIR_UPLOADS];

			foreach ($writables as $name => $dir) self::$requirements[$name] = is_writable($dir);

			# Set checking status

			self::$status = (!in_array(false, self::$requirements));
		}

		# Return list

		public static function requirements() {

			return self::$requirements;
		}

		# Return status

		public static function status() {

			return self::$status;
		}
	}
}
