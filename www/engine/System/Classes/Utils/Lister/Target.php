<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Target extends Lister\Translatable {

		protected static $list = [

			TARGET_SELF                 => 'TARGET_SELF',
			TARGET_BLANK                => 'TARGET_BLANK'
		];
	}
}
