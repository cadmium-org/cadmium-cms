<?php

/**
 * @package Cadmium\System
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Exception {

	class Captcha extends Exception  {

		protected $message = 'Error generating captcha';
	}

	class Sitemap extends Exception  {

		protected $message = 'Error generating sitemap';
	}

	class Language extends Exception  {

		protected $message = 'Languages not found';
	}

	class Template extends Exception  {

		protected $message = 'Templates not found';
	}

	class View extends Exception  {

		protected $message = 'View is not initialized';
	}

	class ViewFile extends Exception  {

		protected $message = 'View file \'$value$\' not found';
	}
}
