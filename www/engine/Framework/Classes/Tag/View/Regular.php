<?php

namespace Tag\View {

	use Template;

	/**
	 * @property-write string $name
	 * @property-write array $attributes
	 * @property-write \Template\Utils\Block|\Template\Utils\Group $contents
	 */

	class Regular extends Template\Utils\Block {

		private static $contents_raw = '<$name${ for:attributes } $name$="$value$"{ / for:attributes }>{ block:contents / }</$name$>';

		# Constructor

		public function __construct() {

			parent::__construct(self::$contents_raw);
		}
	}
}
