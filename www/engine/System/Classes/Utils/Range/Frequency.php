<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Range {

	use Utils\Range;

	abstract class Frequency extends Range {

		protected static $range = [

			FREQUENCY_ALWAYS            => 'FREQUENCY_ALWAYS',
			FREQUENCY_HOURLY            => 'FREQUENCY_HOURLY',
			FREQUENCY_DAILY             => 'FREQUENCY_DAILY',
			FREQUENCY_WEEKLY            => 'FREQUENCY_WEEKLY',
			FREQUENCY_MONTHLY           => 'FREQUENCY_MONTHLY',
			FREQUENCY_YEARLY            => 'FREQUENCY_YEARLY',
			FREQUENCY_NEVER             => 'FREQUENCY_NEVER'
		];
	}
}
