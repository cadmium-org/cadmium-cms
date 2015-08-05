<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Target extends Lister\Translatable {

        # Autoloader

        public static function __autoload() {

            self::$list[get_called_class()] = array (

				TARGET_SELF                 => 'TARGET_SELF',
				TARGET_BLANK                => 'TARGET_BLANK'
    		);
        }
    }
}
