<?php

namespace Utils\Lister {

	use Utils\Lister;

	abstract class Rank extends Lister {

		protected static $list = [

			RANK_GUEST                  => 'RANK_GUEST',
			RANK_USER                   => 'RANK_USER',
			RANK_ADMINISTRATOR          => 'RANK_ADMINISTRATOR'
		];
	}
}
