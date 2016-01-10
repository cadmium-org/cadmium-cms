<?php

namespace Utils\Lister {

	use Utils\Lister;

	abstract class Status extends Lister {

		protected static $list = [

			STATUS_ONLINE               => 'STATUS_ONLINE',
			STATUS_MAINTENANCE          => 'STATUS_MAINTENANCE',
			STATUS_UPDATE               => 'STATUS_UPDATE'
		];
	}
}
