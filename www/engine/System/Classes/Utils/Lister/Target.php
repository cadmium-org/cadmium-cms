<?php

namespace Utils\Lister {

	use Utils\Lister;

	abstract class Target extends Lister {

		protected static $list = [

			TARGET_SELF                 => 'TARGET_SELF',
			TARGET_BLANK                => 'TARGET_BLANK'
		];
	}
}
