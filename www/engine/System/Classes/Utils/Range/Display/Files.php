<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Range\Display {

	use Utils\Range;

	abstract class Files extends Range {

		protected static $range = [

			10 => 10, 20 => 20, 40 => 40, 80 => 80
		];
	}
}
