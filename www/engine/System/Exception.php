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

	# View not initialized exception

	class View extends Exception  {

		protected $message = 'View is not initialized';
	}
}
