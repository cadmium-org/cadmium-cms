<?php

namespace Views {

	use Modules\Extend, Explorer, Template;

	abstract class View extends Template\Asset\Block {

		# Section interface

		protected static $section = '';

		# File name interface

		protected static $file_name = '';

		# Constructor

		public function __construct() {

			if (static::$section !== Extend\Templates::section()) return;

			$file_name = (Extend\Templates::path() . static::$file_name);

			parent::__construct(Explorer::contents($file_name));
		}
	}
}
