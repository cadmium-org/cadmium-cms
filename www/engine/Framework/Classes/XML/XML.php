<?php

/**
 * @package Framework\XML
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class XML {

		/**
		 * Parse a string as XML
		 *
		 * @return SimpleXMLElement|false : the XML object or false on failure
		 */

		public static function parse(string $string) {

			return simplexml_load_string($string);
		}

		/**
		 * Convert an XML object to a string
		 *
		 * @return string|false : the string or false on failure
		 */

		public static function stringify(SimpleXMLElement $xml) {

			if (false === ($xml = dom_import_simplexml($xml))) return false;

			$dom = $xml->ownerDocument; $dom->formatOutput = true;

			# ------------------------

			return $dom->saveXML();
		}

		/**
		 * Load an XML object from a file
		 *
		 * @return SimpleXMLElement|false : the XML object or false on failure
		 */

		public static function load(string $file_name) {

			if (false === ($contents = Explorer::getContents($file_name))) return false;

			return self::parse($contents);
		}

		/**
		 * Save an XML object into a file
		 *
		 * @return int|false : the number of bytes that were written to the file or false on failure
		 */

		public static function save(string $file_name, SimpleXMLElement $xml) {

			if (false === ($xml = self::stringify($xml))) return false;

			return Explorer::putContents($file_name, $xml);
		}

		/**
		 * Output XML
		 */

		public static function output(SimpleXMLElement $xml) {

			Headers::sendNoCache(); Headers::sendStatus(STATUS_CODE_200); Headers::sendContent(MIME_TYPE_XML);

			echo self::stringify($xml);
		}
	}
}
