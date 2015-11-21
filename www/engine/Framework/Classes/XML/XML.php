<?php

namespace {

	abstract class XML {

		const VERSION = '1.0';

		# Create XML object

		public static function create(string $data) {

			$version = self::VERSION; $encoding = CONFIG_DEFAULT_CHARSET;

			$data = ('<?xml version="' . $version . '" encoding="' . $encoding . '" ?>' . $data);

			# ------------------------

			return @simplexml_load_string($data);
		}

		# Output XML data

		public static function output(SimpleXMLElement $xml) {

			Headers::nocache(); Headers::content(MIME_TYPE_XML);

			echo $xml->asXML();
		}
	}
}
