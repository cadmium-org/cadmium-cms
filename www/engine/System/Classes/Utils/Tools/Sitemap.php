<?php

namespace Utils\Tools {

	use Utils\Lister, Date, Explorer, Number, Validate, XML;

	class Sitemap {

		private $xml = null, $loaded = false;

		# Constructor

		public function __construct() {

			$urlset = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />';

			if (false !== ($xml = XML::create($urlset))) $this->xml = $xml;
		}

		# Load sitemap

		public function load(int $time) {

			$file_name = (DIR_SYSTEM_DATA . 'Sitemap.xml');

			$modified = Explorer::modified($file_name);

			if ((false === $modified) || ($modified <= $time)) return false;

			if (false === ($xml = Explorer::xml($file_name))) return false;

			# ------------------------

			return (($this->xml = $xml) && ($this->loaded = true));
		}

		# Save sitemap

		public function save() {

			if ((null === $this->xml) || $this->loaded) return false;

			$file_name = (DIR_SYSTEM_DATA . 'Sitemap.xml');

			# ------------------------

			return Explorer::save($file_name, $this->xml->asXML(), true);
		}

		# Add item

		public function add(string $loc, string $lastmod = null, string $changefreq = null, float $priority = null) {

			if ((null === $this->xml) || $this->loaded) return false;

			if (false === ($loc = Validate::url($loc))) return false;

			# Create url object

			($url = $this->xml->addChild('url'))->addChild('loc', $loc);

			# Set last modified

			if ((null !== $lastmod) && (false !== ($lastmod = Date::validate($lastmod, DATE_FORMAT_W3C)))) {

				$url->addChild('lastmod', $lastmod);
			}

			# Set change frequency

			if ((null !== $changefreq) && (false !== ($changefreq = Lister\Frequency::validate($changefreq)))) {

				$url->addChild('changefreq', $changefreq);
			}

			# Set priority

			if (null !== $priority) $url->addChild('priority', Number::formatFloat($priority, 0, 1, 1));

			# ------------------------

			return true;
		}

		# Return XMl

		public function xml() {

			return $this->xml;
		}
	}
}
