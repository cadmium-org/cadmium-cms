<?php

namespace System\Utils\Tools {

	use System\Utils\Lister, Date, Headers, Number, Validate;

	class Sitemap {

		private $sitemap = false;

		# Constructor

		public function __construct() {

			$version = '1.0'; $encoding = CONFIG_FRAMEWORK_DEFAULT_CHARSET;

			$this->sitemap = simplexml_load_string (

				'<?xml version="' . $version .'" encoding="' . $encoding . '" ?>' .

				'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />'
			);
		}

		# Add item

		public function add($loc, $lastmod = false, $changefreq = false, $priority = false) {

			if (false === ($loc = Validate::url($loc))) return false;

			$lastmod = Date::validate($lastmod, DATE_FORMAT_W3C); $changefreq = Lister::frequency($changefreq, true);

			if (false !== $priority) $priority = Number::priority($priority);

			# Append data

			$url = $this->sitemap->addChild('url'); $url->addChild('loc', $loc);

			if (false !== $lastmod) $url->addChild('lastmod', $lastmod);

			if (false !== $changefreq) $url->addChild('changefreq', $changefreq);

			if (false !== $priority) $url->addChild('priority', $priority);

			# ------------------------

			return true;
		}

		# Output XML data

		public function output() {

			Headers::nocache(); Headers::content(MIME_TYPE_XML);

			echo $this->sitemap->asXML();

			# ------------------------

			return true;
		}
	}
}

?>
