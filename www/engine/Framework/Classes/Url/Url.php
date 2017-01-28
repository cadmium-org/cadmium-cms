<?php

/**
 * @package Cadmium\Framework\Url
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	class Url {

		private $path = [], $query = [];

		/**
		 * Constructor
		 */

		public function __construct(string $url = '') {

			if (false === ($url = parse_url($url))) return;

			# Parse path

			if (isset($url['path'])) foreach (explode('/', $url['path']) as $part) {

				if ('' !== $part) $this->path[] = urldecode($part);
			}

			# Parse query

			if (isset($url['query'])) parse_str($url['query'], $this->query);
		}

		/**
		 * Set a query attribute. If the value is null, an attribute will be removed
		 *
		 * @return Url : the current url object
		 */

		public function setAttribute(string $name, string $value = null) : Url {

			$this->query[$name] = $value;

			return $this;
		}

		/**
		* Get a query attribute
		*
		* @return string|false : the value or false if the attribute does not exist
		*/

		public function getAttribute(string $name) {

			return ($this->query[$name] ?? false);
		}

		/**
		 * Get the slug (a path without leading slash)
		 */

		public function getSlug() : string {

			return implode('/', array_map('urlencode', $this->path));
		}

		/**
		 * Get the url path
		 */

		public function getPath() : string {

			return ('/' . implode('/', array_map('urlencode', $this->path)));
		}

		/**
		 * Get the url query
		 */

		public function getQuery() : string {

			return (($query = http_build_query($this->query)) ? ('?' . $query) : '');
		}

		/**
		 * Get the url path as an array
		 */

		public function getPathParts() : array {

			return $this->path;
		}

		/**
		 * Get the url query as an array
		 */

		public function getQueryParts() : array {

			return $this->query;
		}

		/**
		 * Get the url as a string
		 */

		public function getString(bool $include_query = true) : string {

			return ($this->getPath() . ($include_query ? $this->getQuery() : ''));
		}
	}
}
