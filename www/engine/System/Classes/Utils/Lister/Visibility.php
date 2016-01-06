<?php

namespace Utils\Lister {

	use Utils\Lister;

	abstract class Visibility extends Lister {

		protected static $list = [

			VISIBILITY_DRAFT            => 'VISIBILITY_DRAFT',
			VISIBILITY_PUBLISHED        => 'VISIBILITY_PUBLISHED'
		];
	}
}
