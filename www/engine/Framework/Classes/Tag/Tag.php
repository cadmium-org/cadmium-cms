<?php

/**
 * @package Framework\Tag
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	class Tag {

		private static $dom = null;

		/**
		 * Autoloader
		 */

		public static function __autoload() {

			self::$dom = new DOMDocument;
		}

		/**
		 * Create a new DOM element
		 */

		public static function create(string $name, string $value = '') : DOMElement {

			$element = self::$dom->createElement($name);

			$element->appendChild(self::$dom->createTextNode($value));

			# ------------------------

			return $element;
		}
	}
}
