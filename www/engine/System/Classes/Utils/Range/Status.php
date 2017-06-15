<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

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
