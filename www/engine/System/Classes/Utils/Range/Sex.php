<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Range {

	use Utils\Range;

	abstract class Sex extends Range {

		protected static $range = [

			SEX_NOT_SELECTED            => 'SEX_NOT_SELECTED',
			SEX_MALE                    => 'SEX_MALE',
			SEX_FEMALE                  => 'SEX_FEMALE'
		];
	}
}
