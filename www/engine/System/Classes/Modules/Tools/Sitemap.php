<?php

namespace Modules\Tools {

	use Utils\Range, Utils\Validate, Date, Number, XML;

	class Sitemap {

		private $xml = null, $loaded = false;

		# Constructor

		public function __construct() {

			$urlset = '<?xml version="1.0" encoding="UTF-8" ?>' .

					  '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />';

			if (false !== ($xml = XML::parse($urlset))) $this->xml = $xml;
		}

		# Load sitemap

		public function load(string $file_name) {

			if (false === ($xml = XML::load($file_name))) return false;

			$this->xml = $xml; $this->loaded = true;

			# ------------------------

			return true;
		}

		# Save sitemap

		public function save(string $file_name) {

			if ((null === $this->xml) || $this->loaded) return false;

			if (false === XML::save($file_name, $this->xml)) return false;

			# ------------------------

			return true;
		}

		# Add item

		public function add(string $loc, string $lastmod = null, string $changefreq = null, float $priority = null) {

			if ((null === $this->xml) || $this->loaded) return false;

			if (false === ($loc = Validate::url($loc))) return false;

			# Create url object

			$url = $this->xml->addChild('url'); $url->addChild('loc', $loc);

			# Set last modified

			if ((null !== $lastmod) && (false !== ($lastmod = Date::validate($lastmod, DATE_FORMAT_W3C)))) {

				$url->addChild('lastmod', $lastmod);
			}

			# Set change frequency

			if ((null !== $changefreq) && (false !== ($changefreq = Range\Frequency::validate($changefreq)))) {

				$url->addChild('changefreq', $changefreq);
			}

			# Set priority

			if (null !== $priority) $url->addChild('priority', Number::forceFloat($priority, 0, 1, 1));

			# ------------------------

			return true;
		}

		# Return XMl

		public function xml() {

			return $this->xml;
		}
	}
}
