<?php

namespace Exception {

	# Captcha generate exception

	class Captcha extends Exception  {

		protected $message = 'Error generating captcha';
	}

	# Sitemap generate exception

	class Sitemap extends Exception  {

		protected $message = 'Error generating sitemap';
	}

	# Language not found exception

	class Language extends Exception  {

		protected $message = 'Languages not found';
	}

	# Template not found exception

	class Template extends Exception  {

		protected $message = 'Templates not found';
	}

	# View not initialized exception

	class View extends Exception  {

		protected $message = 'View is not initialized';
	}

	# View file not found exception

	class ViewFile extends Exception  {

		protected $message = 'View file \'$value$\' not found';
	}
}
