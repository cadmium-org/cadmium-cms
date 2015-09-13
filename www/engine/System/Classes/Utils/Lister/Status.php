<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Status extends Lister\Translatable {

		protected static $list = array();

        # Autoloader

        public static function __autoload() {

            self::$list = array (

				STATUS_ONLINE               => 'STATUS_ONLINE',
				STATUS_MAINTENANCE          => 'STATUS_MAINTENANCE',
				STATUS_UPDATE               => 'STATUS_UPDATE'
    		);
        }
    }
}
