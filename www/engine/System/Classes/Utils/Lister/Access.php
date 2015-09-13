<?php

namespace System\Utils\Lister {

    use Lister;

	abstract class Access extends Lister\Translatable {

        protected static $list = array();

        # Autoloader

        public static function __autoload() {

            self::$list = array (

    			ACCESS_PUBLIC               => 'ACCESS_PUBLIC',
    			ACCESS_REGISTERED           => 'ACCESS_REGISTERED',
    			ACCESS_ADMINISTRATOR        => 'ACCESS_ADMINISTRATOR'
    		);
        }
    }
}
