<?php

namespace Utils\Lister {

	use Utils\Lister;

	abstract class Frequency extends Lister {

		protected static $list = [

			FREQUENCY_ALWAYS            => 'FREQUENCY_ALWAYS',
			FREQUENCY_HOURLY            => 'FREQUENCY_HOURLY',
			FREQUENCY_DAILY             => 'FREQUENCY_DAILY',
			FREQUENCY_WEEKLY            => 'FREQUENCY_WEEKLY',
			FREQUENCY_MONTHLY           => 'FREQUENCY_MONTHLY',
			FREQUENCY_YEARLY            => 'FREQUENCY_YEARLY',
			FREQUENCY_NEVER             => 'FREQUENCY_NEVER'
		];
	}
}
