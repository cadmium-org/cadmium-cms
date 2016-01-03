<?php

namespace System\Utils\Lister {

	use System\Utils\Lister;

	abstract class Visibility extends Lister {

		protected static $list = [

			VISIBILITY_DRAFT            => 'VISIBILITY_DRAFT',
			VISIBILITY_PUBLISHED        => 'VISIBILITY_PUBLISHED'
		];
	}
}
