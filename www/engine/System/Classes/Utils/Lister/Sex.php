<?php

namespace System\Utils\Lister {

	use System\Utils\Lister;

	abstract class Sex extends Lister {

		protected static $list = [

			SEX_NOT_SELECTED            => 'SEX_NOT_SELECTED',
			SEX_MALE                    => 'SEX_MALE',
			SEX_FEMALE                  => 'SEX_FEMALE'
		];
	}
}
