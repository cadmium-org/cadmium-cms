<?php

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
