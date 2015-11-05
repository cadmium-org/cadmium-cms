<?php

namespace Tag\View {

	use Template;

	class SelfClosing extends Template\Utils\Block {

		private static $contents_raw = '<$name${ for:attributes } $name$="$value$"{ / for:attributes } />';

		# Constructor

		public function __construct() {

			parent::__construct(self::$contents_raw);
		}
	}
}
