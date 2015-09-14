<?php

namespace System\Utils\Lister {

	use Lister;

	abstract class Rank extends Lister\Translatable {

		protected static $list = [

			RANK_GUEST                  => 'RANK_GUEST',
			RANK_USER                   => 'RANK_USER',
			RANK_ADMINISTRATOR          => 'RANK_ADMINISTRATOR'
		];
	}
}
