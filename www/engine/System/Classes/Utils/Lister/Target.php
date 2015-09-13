<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Target extends Lister\Translatable {

		protected static $list = array();

        # Autoloader

        public static function __autoload() {

            self::$list = array (

				TARGET_SELF                 => 'TARGET_SELF',
				TARGET_BLANK                => 'TARGET_BLANK'
    		);
        }
    }
}
