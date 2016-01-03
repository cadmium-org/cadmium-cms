<?php

namespace {

	abstract class XML {

		# Create XML object

		public static function create(string $data) {

			$data = ('<?xml version="1.0" encoding="UTF-8" ?>' . $data);

			return @simplexml_load_string($data);
		}

		# Output XML data

		public static function output(SimpleXMLElement $xml) {

			Headers::nocache(); Headers::content(MIME_TYPE_XML);

			echo $xml->asXML();
		}
	}
}
