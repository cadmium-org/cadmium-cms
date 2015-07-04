<?php

namespace System\Utils\Tools {

	use System\Utils\Lister, DOMDocument, Date, Headers, Number, Validate;

	class Sitemap {

		private $sitemap = false, $urlset = false;

		# Constructor

		public function __construct() {

			$this->sitemap = new DOMDocument('1.0', CONFIG_FRAMEWORK_DEFAULT_CHARSET);

			$this->sitemap->formatOutput = true;

			$this->sitemap->appendChild($this->urlset = $this->sitemap->createElement('urlset'));

			$this->urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
		}

		# Add item

		public function add($loc, $lastmod = false, $changefreq = false, $priority = false) {

			if (false === ($loc = Validate::url($loc))) return false;

			$lastmod = Date::validate($lastmod, DATE_FORMAT_W3C); $changefreq = Lister::frequency($changefreq, true);

			if (false !== $priority) $priority = Number::priority($priority);

			$this->urlset->appendChild($url = $this->sitemap->createElement('url'));

			$url->appendChild($this->sitemap->createElement('loc', $loc));

			if (false !== $lastmod) $url->appendChild($this->sitemap->createElement('lastmod', $lastmod));

			if (false !== $changefreq) $url->appendChild($this->sitemap->createElement('changefreq', $changefreq));

			if (false !== $priority) $url->appendChild($this->sitemap->createElement('priority', $priority));

			# ------------------------

			return true;
		}

		# Output XML data

		public function output() {

			Headers::nocache(); Headers::content(MIME_TYPE_XML);

			echo $this->sitemap->saveXML();

			# ------------------------

			return true;
		}
	}
}

?>
