<?php

namespace Form\View {

	use Template;

	/**
	 * @property-write array $options
	 */

	class Options extends Template\Utils\Block {

		private static $contents_raw = '{ for:options }<option value="$value$"$selected$>$text$</option>{ / for:options }';

		# Constructor

		public function __construct() {

			parent::__construct(self::$contents_raw);
		}
	}
}
