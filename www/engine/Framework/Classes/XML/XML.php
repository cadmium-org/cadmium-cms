<?php

namespace {

	abstract class XML {

		const VERSION = '1.0';

		# Create XML object

		public static function create() {

			return simplexml_load_string (

				'<?xml version="' . self::VERSION .'" encoding="' . CONFIG_DEFAULT_CHARSET . '" ?>' .

				'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />'
			);
		}

		# Output XML

		public static function output(SimpleXMLElement $xml) {

			Headers::nocache(); Headers::content(MIME_TYPE_XML);

			echo $xml->asXML();
		}
	}
}
