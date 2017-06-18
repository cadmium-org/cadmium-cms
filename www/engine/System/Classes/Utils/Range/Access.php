<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Range {

	use Utils\Range;

	abstract class Access extends Range {

		protected static $range = [

			ACCESS_PUBLIC               => 'ACCESS_PUBLIC',
			ACCESS_REGISTERED           => 'ACCESS_REGISTERED',
			ACCESS_ADMINISTRATOR        => 'ACCESS_ADMINISTRATOR'
		];
	}
}
