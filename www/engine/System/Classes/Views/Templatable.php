<?php

namespace System\Views {

	use System\Modules\Extend;

	abstract class Templatable extends View {

		# Section interface

		const SECTION = '';

		# File name interface

		protected static $file_name = '';

		# Constructor

		public function __construct() {

			if (static::SECTION === Extend\Templates::section()) {

				parent::__construct(Extend\Templates::path() . static::$file_name);
			}
		}
	}
}
