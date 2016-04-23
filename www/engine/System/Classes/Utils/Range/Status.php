<?php

namespace Utils\Range {

	use Utils\Range;

	abstract class Status extends Range {

		protected static $range = [

			STATUS_ONLINE               => 'STATUS_ONLINE',
			STATUS_MAINTENANCE          => 'STATUS_MAINTENANCE',
			STATUS_UPDATE               => 'STATUS_UPDATE'
		];
	}
}
