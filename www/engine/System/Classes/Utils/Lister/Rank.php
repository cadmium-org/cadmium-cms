<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Rank extends Lister\Translatable {

        # Autoloader

        public static function __autoload() {

            self::$list[get_called_class()] = array (

				RANK_GUEST                  => 'RANK_GUEST',
				RANK_USER                   => 'RANK_USER',
				RANK_ADMINISTRATOR          => 'RANK_ADMINISTRATOR'
    		);
        }
    }
}
