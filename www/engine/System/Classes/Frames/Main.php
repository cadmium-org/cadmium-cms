<?php

/**
 * @package Cadmium\System\Frames
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Frames {

	use Modules\Settings, Session, Url;

	abstract class Main {

		protected $_url = null;

		/**
		 * Constructor
		 */

		public function __construct(Url $url = null) {

			$this->_url = ($url ?? new Url);

			# Start session

			Session::start(CONFIG_SESSION_NAME, CONFIG_SESSION_LIFETIME);

			# Load settings

			Settings::load();

			# Set timezone

			date_default_timezone_set(Settings::get('system_timezone'));

			# ------------------------

			$this->_main();
		}

		/**
		 * The interface for a main branch method
		 */

		abstract protected function _main();
	}
}
