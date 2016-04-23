<?php

namespace Utils\Range {

	use Utils\Range;

	abstract class Visibility extends Range {

		protected static $range = [

			VISIBILITY_DRAFT            => 'VISIBILITY_DRAFT',
			VISIBILITY_PUBLISHED        => 'VISIBILITY_PUBLISHED'
		];
	}
}
