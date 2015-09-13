<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Sex extends Lister\Translatable {

		protected static $list = array();

        # Autoloader

        public static function __autoload() {

            self::$list = array (

				SEX_NOT_SELECTED            => 'SEX_NOT_SELECTED',
				SEX_MALE                    => 'SEX_MALE',
				SEX_FEMALE                  => 'SEX_FEMALE'
    		);
        }
    }
}
