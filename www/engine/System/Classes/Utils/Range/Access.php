<?php

namespace Utils\Range {

	use Utils\Range;

	abstract class Access extends Range {

		protected static $range = [

			ACCESS_PUBLIC               => 'ACCESS_PUBLIC',
			ACCESS_REGISTERED           => 'ACCESS_REGISTERED',
			ACCESS_ADMINISTRATOR        => 'ACCESS_ADMINISTRATOR'
		];
	}
}
