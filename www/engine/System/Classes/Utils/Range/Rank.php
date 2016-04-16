<?php

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
