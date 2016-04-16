<?php

namespace Utils\Range {

	use Utils\Range;

	abstract class Target extends Range {

		protected static $range = [

			TARGET_SELF                 => 'TARGET_SELF',
			TARGET_BLANK                => 'TARGET_BLANK'
		];
	}
}
