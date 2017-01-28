<?php

/**
 * @package Cadmium\Framework\Debug
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Debug {

		/**
		 * Get the peak memory in bytes, that's been allocated to the script
		 */

		public static function getMemory() : int {

			return memory_get_peak_usage();
		}

		/**
		 * Get the time in seconds, that's passed since the script started
		 */

		public static function getTime() : string {

			return number_format((microtime(true) - REQUEST_TIME_FLOAT), 10);
		}
	}
}
