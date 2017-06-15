<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Range {

	use Utils\Range;

	abstract class Target extends Range {

		protected static $range = [

			TARGET_SELF                 => 'TARGET_SELF',
			TARGET_BLANK                => 'TARGET_BLANK'
		];
	}
}
