<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Access extends Lister\Translatable {

		protected static $list = [

			ACCESS_PUBLIC               => 'ACCESS_PUBLIC',
			ACCESS_REGISTERED           => 'ACCESS_REGISTERED',
			ACCESS_ADMINISTRATOR        => 'ACCESS_ADMINISTRATOR'
		];
	}
}
