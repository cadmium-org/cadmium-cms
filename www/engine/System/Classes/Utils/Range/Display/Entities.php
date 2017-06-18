<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Range\Display {

	use Utils\Range;

	abstract class Entities extends Range {

		protected static $range = [

			10 => 10, 25 => 25, 50 => 50, 100 => 100
		];
	}
}
