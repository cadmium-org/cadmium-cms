<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Visibility extends Lister\Translatable {

		protected static $list = array();

        # Autoloader

        public static function __autoload() {

            self::$list = array (

				VISIBILITY_DRAFT            => 'VISIBILITY_DRAFT',
				VISIBILITY_PUBLISHED        => 'VISIBILITY_PUBLISHED'
    		);
        }
    }
}
