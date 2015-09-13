<?php

namespace System\Modules {

	abstract class Install {

        private static $requirements = array(), $status = false;

        # Autoloader

        public static function __autoload() {

            # Check if mysqli extension loaded

			self::$requirements['mysqli'] = extension_loaded('mysqli');

			# Check if mbstring extension loaded

			self::$requirements['mbstring'] = extension_loaded('mbstring');

			# Check if gd extension loaded

			self::$requirements['gd'] = extension_loaded('gd');

			# Check if simplexml extension loaded

			self::$requirements['simplexml'] = extension_loaded('simplexml');

			# Check if mod_rewrite enabled

			self::$requirements['rewrite'] = (function_exists('apache_get_modules') &&

                in_array('mod_rewrite', apache_get_modules()));

			# Check if data directory is writable

			self::$requirements['data'] = is_writable(DIR_SYSTEM_DATA);

			# Check if uploads directory is writable

			self::$requirements['uploads'] = is_writable(DIR_UPLOADS);

            # Determine checking status

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
