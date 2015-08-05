<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Status extends Lister\Translatable {

        # Autoloader

        public static function __autoload() {

            self::$list[get_called_class()] = array (

				STATUS_ONLINE               => 'STATUS_ONLINE',
				STATUS_MAINTENANCE          => 'STATUS_MAINTENANCE',
				STATUS_UPDATE               => 'STATUS_UPDATE'
    		);
        }
    }
}
