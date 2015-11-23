<?php

namespace System\Views {

	use System\Modules\Extend, Explorer, Template;

	abstract class View extends Template\Asset\Block {

		# Section interface

		const SECTION = '';

		# File name interface

		protected static $file_name = '';

		# Constructor

		public function __construct() {

			if (static::SECTION !== Extend\Templates::section()) return;

			$file_name = (Extend\Templates::path() . static::$file_name);

			parent::__construct(Explorer::contents($file_name));
		}
	}
}
