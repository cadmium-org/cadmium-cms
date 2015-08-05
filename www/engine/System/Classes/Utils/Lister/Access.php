<?php

namespace System\Utils\Lister {

    use Lister;

	abstract class Access extends Lister\Translatable {

        # Autoloader

        public static function __autoload() {

            self::$list[get_called_class()] = array (

    			ACCESS_PUBLIC               => 'ACCESS_PUBLIC',
    			ACCESS_REGISTERED           => 'ACCESS_REGISTERED',
    			ACCESS_ADMINISTRATOR        => 'ACCESS_ADMINISTRATOR'
    		);
        }
    }
}
