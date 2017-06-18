<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Range {

	use Utils\Range;

	abstract class Visibility extends Range {

		protected static $range = [

			VISIBILITY_DRAFT            => 'VISIBILITY_DRAFT',
			VISIBILITY_PUBLISHED        => 'VISIBILITY_PUBLISHED'
		];
	}
}
