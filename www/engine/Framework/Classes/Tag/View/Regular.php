<?php

namespace Tag\View {

	use Template;

	class Regular extends Template\Asset\Block {

		private static $contents_raw = '<$name${ for:attributes } $name$="$value$"{ / for:attributes }>{ block:contents / }</$name$>';

		# Constructor

		public function __construct() {

			parent::__construct(self::$contents_raw);
		}
	}
}
