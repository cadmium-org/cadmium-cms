<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Range {

	use Utils\Range;

	abstract class Rank extends Range {

		protected static $range = [

			RANK_GUEST                  => 'RANK_GUEST',
			RANK_USER                   => 'RANK_USER',
			RANK_ADMINISTRATOR          => 'RANK_ADMINISTRATOR'
		];
	}
}
