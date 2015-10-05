<?php

namespace Tag\View {

	use Template;

	/**
	 * @property-write string $name
	 * @property-write array $attributes
	 */

	class SelfClosing extends Template\Utils\Block {

		private static $contents_raw = '<$name${ for:attributes } $name$="$value$"{ / for:attributes } />';

		# Constructor

		public function __construct() {

			parent::__construct(self::$contents_raw);
		}
	}
}
