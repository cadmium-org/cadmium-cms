<?php

namespace Form\View {

	use Template;

	class Options extends Template\Asset\Block {

		private static $contents_raw = '{ for:options }<option value="$value$"$selected$>$text$</option>{ / for:options }';

		# Constructor

		public function __construct() {

			parent::__construct(self::$contents_raw);
		}
	}
}
