<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Sex extends Lister\Translatable {

        # Autoloader

        public static function __autoload() {

            self::$list[get_called_class()] = array (

				SEX_NOT_SELECTED            => 'SEX_NOT_SELECTED',
				SEX_MALE                    => 'SEX_MALE',
				SEX_FEMALE                  => 'SEX_FEMALE'
    		);
        }
    }
}
