<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Visibility extends Lister\Translatable {

        # Autoloader

        public static function __autoload() {

            self::$list[get_called_class()] = array (

				VISIBILITY_DRAFT            => 'VISIBILITY_DRAFT',
				VISIBILITY_PUBLISHED        => 'VISIBILITY_PUBLISHED'
    		);
        }
    }
}