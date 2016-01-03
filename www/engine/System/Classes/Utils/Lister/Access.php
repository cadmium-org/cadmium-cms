<?php

namespace System\Utils\Lister {

	use System\Utils\Lister;

	abstract class Access extends Lister {

		protected static $list = [

			ACCESS_PUBLIC               => 'ACCESS_PUBLIC',
			ACCESS_REGISTERED           => 'ACCESS_REGISTERED',
			ACCESS_ADMINISTRATOR        => 'ACCESS_ADMINISTRATOR'
		];
	}
}
