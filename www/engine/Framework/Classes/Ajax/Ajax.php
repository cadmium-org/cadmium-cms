<?php

/**
 * @package Cadmium\Framework\Ajax
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Ajax {

		/**
		 * Create a new response object
		 */

		public static function createResponse() : Ajax\Response {

			return new Ajax\Response;
		}

		/**
		 * Check if a given variable is a response object
		 */

		public static function isResponse($object) : bool {

			return ($object instanceof Ajax\Response);
		}

		/**
		 * Output JSON data contained in a given response object
		 */

		public static function output(Ajax\Response $response) {

			JSON::output($response->getData());
		}
	}
}
