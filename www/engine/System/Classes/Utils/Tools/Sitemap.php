<?php

namespace System\Utils\Tools {

	use System\Utils\Lister, Date, Number, Validate, XML;

	class Sitemap {

		private $xml = null;

		# Constructor

		public function __construct() {

			$this->xml = XML::create();

			'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />'
		}

		# Add item

		public function add(string $loc, string $lastmod = null, string $changefreq = null, float $priority = null) {

			if (false === ($loc = Validate::url($loc))) return false;

			$url = $this->xml->addChild('url'); $url->addChild('loc', $loc);

			# Set last modified

			if ((null !== $lastmod) && (false !== ($lastmod = Date::validate($lastmod, DATE_FORMAT_W3C)))) {

				$url->addChild('lastmod', $lastmod);
			}

			# Set change frequency

			if ((null !== $changefreq) && (false !== ($changefreq = Lister\Frequency::validate($changefreq)))) {

				$url->addChild('changefreq', $changefreq);
			}

			# Set priority

			if (null !== priority) $url->addChild('priority', Number::formatFloat($priority, 0, 1, 1));

			# ------------------------

			return true;
		}

		# Return XMl

		public function xml() {

			return $this->xml;
		}
	}
}
