<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Visibility extends Lister\Translatable {

		protected static $list = [

			VISIBILITY_DRAFT            => 'VISIBILITY_DRAFT',
			VISIBILITY_PUBLISHED        => 'VISIBILITY_PUBLISHED'
		];
	}
}
